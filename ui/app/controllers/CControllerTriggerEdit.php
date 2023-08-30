<?php declare(strict_types = 0);
/*
** Zabbix
** Copyright (C) 2001-2023 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/

require_once __DIR__ .'/../../include/forms.inc.php';

class CControllerTriggerEdit extends CController {

	/**
	 * @var array
	 */
	private $trigger;

	protected function init(): void {
		$this->disableCsrfValidation();
		$this->setPostContentType(self::POST_CONTENT_TYPE_JSON);
	}

	protected function checkInput(): bool {
		$fields = [
			'context' =>				'in '.implode(',', ['host', 'template']),
			'correlation_mode' =>		'db triggers.correlation_mode|in '.implode(',', [ZBX_TRIGGER_CORRELATION_NONE, ZBX_TRIGGER_CORRELATION_TAG]),
			'correlation_tag' =>		'db triggers.correlation_tag',
			'dependencies' =>			'array',
			'description' =>			'db triggers.comments',
			'event_name' =>				'db triggers.event_name',
			'expression' =>				'db triggers.expression',
			'hostid' =>					'db hosts.hostid',
			'manual_close' =>			'db triggers.manual_close|in '.implode(',',[ZBX_TRIGGER_MANUAL_CLOSE_NOT_ALLOWED, ZBX_TRIGGER_MANUAL_CLOSE_ALLOWED]),
			'name' =>					'string',
			'opdata' =>					'db triggers.opdata',
			'priority' =>				'db triggers.priority|in 0,1,2,3,4,5',
			'recovery_expression' =>	'db triggers.recovery_expression',
			'recovery_mode' =>			'db triggers.recovery_mode|in '.implode(',', [ZBX_RECOVERY_MODE_EXPRESSION, ZBX_RECOVERY_MODE_RECOVERY_EXPRESSION, ZBX_RECOVERY_MODE_NONE]),
			'status' =>					'db triggers.status|in '.implode(',', [TRIGGER_STATUS_ENABLED, TRIGGER_STATUS_DISABLED]),
			'show_inherited_tags' =>	'in 0,1',
			'form_refresh' =>			'in 0,1',
			'tags' =>					'array',
			'triggerid' =>				'db triggers.triggerid',
			'type' =>					'db triggers.type|in 0,1',
			'url' =>					'db triggers.url',
			'url_name' =>				'db triggers.url_name'
		];

		$ret = $this->validateInput($fields);

		if (!$ret) {
			$this->setResponse(
				(new CControllerResponseData(['main_block' => json_encode([
					'error' => [
						'messages' => array_column(get_and_clear_messages(), 'message')
					]
				])]))->disableView()
			);
		}

		return $ret;
	}

	protected function checkPermissions(): bool {
		if ($this->hasInput('triggerid')) {
			$parameters = [
				'output' => ['triggerid', 'expression', 'description', 'url', 'status', 'priority', 'comments',
					'templateid', 'type', 'state', 'flags', 'recovery_mode', 'recovery_expression', 'correlation_mode',
					'correlation_tag', 'manual_close', 'opdata', 'event_name', 'url_name'
				],
				'triggerids' => $this->getInput('triggerid'),
				'selectHosts' => ['hostid'],
				'selectDiscoveryRule' => ['itemid', 'name', 'templateid'],
				'selectTriggerDiscovery' => ['parent_triggerid'],
				'selectDependencies' => ['triggerid'],
				'selectTags' => ['tag', 'value']
			];

			if ($this->hasInput('show_inherited_tags') && $this->getInput('show_inherited_tags')) {
				$parameters['selectItems'] = ['itemid', 'templateid', 'flags'];
			}

			$this->trigger = API::Trigger()->get($parameters);

			if (!$this->trigger) {
				return false;
			}
		}
		else {
			$this->trigger = null;
		}

		return true;
	}

	protected function doAction() {
		$form_fields = [
			'hostid' => 0,
			'context' => '',
			'expression' => '',
			'recovery_expression' => '',
			'manual_close' => ZBX_TRIGGER_MANUAL_CLOSE_ALLOWED,
			'correlation_mode' => ZBX_TRIGGER_CORRELATION_NONE,
			'correlation_tag' => '',
			'opdata' => '',
			'priority' => '0',
			'recovery_mode' => ZBX_RECOVERY_MODE_EXPRESSION,
			'type' => '0',
			'event_name' => '',
			'limited' => false,
			'tags' =>[],
			'triggerid' => null,
			'show_inherited_tags' => 0,
			'form_refresh' => 0,
			'status' => TRIGGER_STATUS_ENABLED,
			'templates' => [],
			'db_dependencies' => [],
			'url' => '',
			'url_name' => ''
		];

		$data = [];
		$this->getInputs($data, array_keys($form_fields));

		if ($this->hasInput('form_refresh') && $data['form_refresh']) {
			$data['manual_close'] = !array_key_exists('manual_close', $data)
				? ZBX_TRIGGER_MANUAL_CLOSE_NOT_ALLOWED
				: ZBX_TRIGGER_MANUAL_CLOSE_ALLOWED;

			$data['status'] = $this->hasInput('status') ? TRIGGER_STATUS_ENABLED : TRIGGER_STATUS_DISABLED;
		}

		$data += $form_fields;

		$data['description'] = $this->getInput('name', '');
		$data['comments'] = $this->getInput('description', '');
		$data['dependencies'] =  zbx_toObject($this->getInput('dependencies', []), 'triggerid');

		if ($data['tags'] && ($data['show_inherited_tags'] == 0 || !$this->trigger)) {
			// Unset inherited tags.
			$tags = [];

			foreach ($data['tags'] as $tag) {
				if (array_key_exists('type', $tag) && !($tag['type'] & ZBX_PROPERTY_OWN)) {
					continue;
				}

				$tags[] = [
					'tag' => $tag['tag'],
					'value' => $tag['value']
				];
			}

			$data['tags'] = $tags;
		}
		elseif ($data['tags']) {
			$tags = $data['tags'];

			foreach ($tags as $key => $tag) {
				if ($tag['tag'] === '' && $tag['value'] === '') {
					unset($tags[$key]);
				}
			}

			$data['tags'] = $tags;
		}

		if ($this->trigger) {
			$trigger = $this->getAdditionalTriggerData($data, $data['tags']);

			if ($data['form_refresh']) {
				if ($data['show_inherited_tags']) {
					$data['tags'] = $trigger['tags'];
				}

				$data = array_merge($data, [
					'templateid' => $trigger['templateid'],
					'limited' => $trigger['limited'],
					'flags' => $trigger['flags'],
					'templates' => $trigger['templates'],
					'discoveryRule' => $trigger['discoveryRule'],
					'triggerDiscovery' => $trigger['triggerDiscovery']
				]);
			}
			else {
				$data = $trigger;
			}
		}

		if ($data['dependencies']) {
			$data['db_dependencies'] = API::Trigger()->get([
				'output' => ['triggerid', 'description', 'flags'],
				'selectHosts' => ['hostid', 'name'],
				'triggerids' => array_column($data['dependencies'], 'triggerid'),
				'preservekeys' => true
			]);

			foreach ($data['db_dependencies'] as &$dependency) {
				order_result($dependency['hosts'], 'name', ZBX_SORT_UP);
			}
			unset($dependency);

			order_result($data['db_dependencies'], 'description');
		}

		$data['expression_full'] = $data['expression'];
		$data['recovery_expression_full'] = $data['recovery_expression'];

		if (!$data['tags']) {
			$data['tags'][] = ['tag' => '', 'value' => ''];
		}
		else {
			CArrayHelper::sort($data['tags'], ['tag', 'value']);
		}

		$data['user'] = ['debug_mode' => $this->getDebugMode()];

		$response = new CControllerResponseData($data);
		$this->setResponse($response);
	}

	/**
	 * Collects information about the existing trigger.
	 *
	 * @param array $data
	 * @return array
	 */
	private function getAdditionalTriggerData(array $data, array $input_tags): array {
		$triggers = CMacrosResolverHelper::resolveTriggerExpressions($this->trigger,
			['sources' => ['expression', 'recovery_expression']]
		);

		$data = array_merge($data, reset($triggers));

		// Get templates.
		$data['templates'] = makeTriggerTemplatesHtml($data['triggerid'],
			getTriggerParentTemplates([$data], ZBX_FLAG_DISCOVERY_NORMAL), ZBX_FLAG_DISCOVERY_NORMAL,
			CWebUser::checkAccess(CRoleHelper::UI_CONFIGURATION_TEMPLATES)
		);

		if ($data['show_inherited_tags']) {
			$data['tags'] = $this->getInheritedTags($data, $input_tags);
		}

		$data['limited'] = ($data['templateid'] != 0);

		if ($data['hostid'] == 0) {
			$data['hostid'] = $data['hosts'][0]['hostid'];
		}

		return $data;
	}

	/**
	 * Add trigger inherited tags to $data['tags'] array of trigger tags.
	 *
	 * @param array $data
	 * @param array $input_tags
	 */
	private function getInheritedTags(array $data, array $input_tags): array {
		$items = [];
		$item_prototypes = [];

		foreach ($data['items'] as $item) {
			if ($item['flags'] == ZBX_FLAG_DISCOVERY_NORMAL) {
				$items[] = $item;
			}
			else {
				$item_prototypes[] = $item;
			}
		}

		$item_parent_templates = getItemParentTemplates($items, ZBX_FLAG_DISCOVERY_NORMAL)['templates']
			+ getItemParentTemplates($item_prototypes, ZBX_FLAG_DISCOVERY_PROTOTYPE)['templates'];

		unset($item_parent_templates[0]);

		$db_templates = $item_parent_templates
			? API::Template()->get([
				'output' => ['templateid'],
				'selectTags' => ['tag', 'value'],
				'templateids' => array_keys($item_parent_templates),
				'preservekeys' => true
			])
			: [];

		$inherited_tags = [];

		// Make list of parent template tags.
		foreach ($item_parent_templates as $templateid => $template) {
			if (array_key_exists($templateid, $db_templates)) {
				foreach ($db_templates[$templateid]['tags'] as $tag) {
					if (array_key_exists($tag['tag'], $inherited_tags)
						&& array_key_exists($tag['value'], $inherited_tags[$tag['tag']])) {
						$inherited_tags[$tag['tag']][$tag['value']]['parent_templates'] += [
							$templateid => $template
						];
					}
					else {
						$inherited_tags[$tag['tag']][$tag['value']] = $tag + [
								'parent_templates' => [$templateid => $template],
								'type' => ZBX_PROPERTY_INHERITED
							];
					}
				}
			}
		}

		$db_hosts = API::Host()->get([
			'output' => [],
			'selectTags' => ['tag', 'value'],
			'hostids' => $data['hostid'],
			'templated_hosts' => true
		]);

		// Overwrite and attach host level tags.
		if ($db_hosts) {
			foreach ($db_hosts[0]['tags'] as $tag) {
				$inherited_tags[$tag['tag']][$tag['value']] = $tag;
				$inherited_tags[$tag['tag']][$tag['value']]['type'] = ZBX_PROPERTY_INHERITED;
			}
		}

		// Overwrite and attach trigger's own tags.
		foreach ($input_tags as $tag) {
			if (array_key_exists($tag['tag'], $inherited_tags)
					&& array_key_exists($tag['value'], $inherited_tags[$tag['tag']])
			) {
				if (!array_key_exists('type', $tag) || $tag['type'] != ZBX_PROPERTY_INHERITED) {
					$inherited_tags[$tag['tag']][$tag['value']]['type'] = ZBX_PROPERTY_BOTH;
				}
			}
			else {
				$inherited_tags[$tag['tag']][$tag['value']] = $tag + ['type' => ZBX_PROPERTY_OWN];
			}
		}

		$data['tags'] = [];

		foreach ($inherited_tags as $tag) {
			foreach ($tag as $value) {
				$data['tags'][] = $value;
			}
		}

		return $data['tags'];
	}
}
