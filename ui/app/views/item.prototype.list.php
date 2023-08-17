<?php
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


/**
 * @var CView $this
 */

$this->addJsFile('multilineinput.js');
$this->addJsFile('items.js');
$this->includeJsFile('item.prototype.list.js.php');

$form = (new CForm())
	->setName('itemprototype')
	->addVar('parent_discoveryid', $data['parent_discoveryid'], 'form_parent_discoveryid')
	->addVar('context', $data['context']);

$list_url = (new CUrl('zabbix.php'))
	->setArgument('action', $data['action'])
	->setArgument('parent_discoveryid', $data['parent_discoveryid'])
	->setArgument('context', $data['context'])
	->getUrl();

$table = (new CTableInfo())
	->setHeader([
		(new CColHeader(
			(new CCheckBox('all_items'))->onClick("checkAll('".$form->getName()."', 'all_items', 'itemids');")
		))->addClass(ZBX_STYLE_CELL_WIDTH),
		'',
		make_sorting_header(_('Name'),'name', $data['sort'], $data['sortorder'], $list_url),
		make_sorting_header(_('Key'), 'key_', $data['sort'], $data['sortorder'], $list_url),
		make_sorting_header(_('Interval'), 'delay', $data['sort'], $data['sortorder'], $list_url),
		make_sorting_header(_('History'), 'history', $data['sort'], $data['sortorder'], $list_url),
		make_sorting_header(_('Trends'), 'trends', $data['sort'], $data['sortorder'], $list_url),
		make_sorting_header(_('Type'), 'type', $data['sort'], $data['sortorder'], $list_url),
		make_sorting_header(_('Create enabled'), 'status', $data['sort'], $data['sortorder'], $list_url),
		make_sorting_header(_('Discover'), 'discover', $data['sort'], $data['sortorder'], $list_url),
		_('Tags')
	]);

foreach ($data['items'] as $item) {
	$name = [makeItemTemplatePrefix($item['itemid'], $data['parent_templates'], ZBX_FLAG_DISCOVERY_PROTOTYPE,
		$data['allowed_ui_conf_templates']
	)];

	if ($item['type'] == ITEM_TYPE_DEPENDENT) {
		if ($item['master_item']['type'] == ITEM_TYPE_HTTPTEST) {
			$name[] = $item['master_item']['name'];
		}
		else {
			if ($item['master_item']['source'] === 'itemprototypes') {
				$name[] = (new CLink($item['master_item']['name']))
					->addClass(ZBX_STYLE_LINK_ALT)
					->addClass(ZBX_STYLE_TEAL)
					->addClass('js-update-itemprototype')
					->setAttribute('data-itemid', $item['master_item']['itemid'])
					->setAttribute('data-parent_discoveryid', $data['parent_discoveryid'])
					->setAttribute('data-context', $data['context']);
			}
			else {
				$name[] = (new CLink($item['master_item']['name']))
					->addClass(ZBX_STYLE_LINK_ALT)
					->addClass(ZBX_STYLE_TEAL)
					->addClass('js-update-item')
					->setAttribute('data-itemid', $item['master_item']['itemid'])
					->setAttribute('data-context', $data['context']);
			}
		}

		$name[] = NAME_DELIMITER;
	}

	$name[] = (new CLink($item['name']))
		->addClass('js-update-itemprototype')
		->setAttribute('data-itemid', $item['itemid'])
		->setAttribute('data-parent_discoveryid', $data['parent_discoveryid'])
		->setAttribute('data-context', $data['context']);

	$table->addRow([
		new CCheckBox('itemids['.$item['itemid'].']', $item['itemid']),
		(new CButtonIcon(ZBX_ICON_MORE))
			->setMenuPopup(
				CMenuPopupHelper::getItemPrototype([
					'itemid' => $item['itemid'],
					'context' => $data['context'],
					'backurl' => $list_url
				])
			),
		$name,
		(new CDiv($item['key_']))->addClass(ZBX_STYLE_WORDWRAP),
		$item['delay'],
		$item['history'],
		$item['trends'],
		item_type2str($item['type']),
		(new CLink(($item['status'] == ITEM_STATUS_DISABLED) ? _('No') : _('Yes')))
			->addClass(ZBX_STYLE_LINK_ACTION)
			->addClass(itemIndicatorStyle($item['status']))
			->addClass($item['status'] == ITEM_STATUS_DISABLED ? 'js-enable-item' : 'js-disable-item')
			->setAttribute('data-itemid', $item['itemid'])
			->setAttribute('data-field', 'status')
			->setAttribute('data-context', $data['context']),
		(new CLink(($item['discover'] == ZBX_PROTOTYPE_NO_DISCOVER) ? _('No') : _('Yes')))
			->addClass(ZBX_STYLE_LINK_ACTION)
			->addClass($item['discover'] == ZBX_PROTOTYPE_NO_DISCOVER ? ZBX_STYLE_RED : ZBX_STYLE_GREEN)
			->addClass($item['discover'] == ZBX_PROTOTYPE_NO_DISCOVER ? 'js-enable-item' : 'js-disable-item')
			->setAttribute('data-itemid', $item['itemid'])
			->setAttribute('data-field', 'discover')
			->setAttribute('data-context', $data['context']),
		$data['tags'][$item['itemid']]
	]);
}

$form->addItem([$table, $data['paging']]);

$buttons = [
	[
		'content' => (new CSimpleButton(_('Create enabled')))
			->addClass(ZBX_STYLE_BTN_ALT)
			->addClass('js-massenable-itemprototype')
			->addClass('js-no-chkbxrange')
	],
	[
		'content' => (new CSimpleButton(_('Create disabled')))
			->addClass(ZBX_STYLE_BTN_ALT)
			->addClass('js-massdisable-itemprototype')
			->addClass('js-no-chkbxrange')
	],
	[
		'content' => (new CSimpleButton(_('Mass update')))
			->addClass(ZBX_STYLE_BTN_ALT)
			->addClass('js-massupdate-itemprototype')
			->addClass('js-no-chkbxrange')
	],
	[
		'content' => (new CSimpleButton(_('Delete')))
			->addClass(ZBX_STYLE_BTN_ALT)
			->addClass('js-massdelete-itemprototype')
			->addClass('js-no-chkbxrange')
	]
];

$form->addItem(new CActionButtonList('action', 'itemids', $buttons, 'itemprototype'));

(new CHtmlPage())
	->setTitle(_('Item prototypes'))
	->setDocUrl(CDocHelper::getUrl($data['context'] === 'host'
		? CDocHelper::DATA_COLLECTION_HOST_ITEM_PROTOTYPE_LIST
		: CDocHelper::DATA_COLLECTION_TEMPLATES_ITEM_PROTOTYPE_LIST
	))
	->setControls(
		(new CTag('nav', true,
			(new CList())
				->addItem(
					(new CSimpleButton(_('Create item prototype')))
						->setAttribute('data-parent_discoveryid', $data['parent_discoveryid'])
						->setAttribute('data-context', $data['context'])
						->addClass('js-create-item-prototype')
				)
		))->setAttribute('aria-label', _('Content controls'))
	)
	->setNavigation(getHostNavigation('items', $data['hostid'], $data['parent_discoveryid']))
	->addItem($form)
	->show();

$confirm_messages = [
	'item.prototype.enable' => [_('Create items from selected prototype as enabled?'),
		_('Create items from selected prototypes as enabled?')
	],
	'item.prototype.disable' => [_('Create items from selected prototype as disabled?'),
		_('Create items from selected prototypes as disabled?')
	],
	'item.prototype.delete' => [_('Delete selected item prototype?'), _('Delete selected item prototypes?')]
];

	(new CScriptTag('
		view.init('.json_encode([
			'token' => [
				'token' => CCsrfTokenHelper::CSRF_TOKEN_NAME,
				'value' => CCsrfTokenHelper::get('item')
			],
			'confirm_messages' => $confirm_messages,
			'context' => $data['context'],
			'form_name' => $form->getName()
		]).');
	'))
	->setOnDocumentReady()
	->show();
