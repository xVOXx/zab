<?php
/*
** Zabbix
** Copyright (C) 2001-2024 Zabbix SIA
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


require_once dirname(__FILE__).'/../include/CWebTest.php';
require_once dirname(__FILE__).'/behaviors/CMessageBehavior.php';

/**
 * @backup events, problem, hosts, profiles
 *
 * @onBefore prepareAlarmData
 */
class testFormAlarmNotification extends CWebTest {

	/**
	 * Attach MessageBehavior to the test.
	 *
	 * @return array
	 */
	public function getBehaviors()
	{
		return [
			CMessageBehavior::class
		];
	}

	protected static $itemids;
	protected static $triggersid;

	public static function prepareAlarmData() {
		$response = CDataHelper::createHosts([
			[
				'host' => 'Host for alarm item',
				'groups' => [['groupid' => 4]], // Zabbix server
				'items' => [
					[
						'name' => 'Not classified',
						'key_' => 'not_classified',
						'type' => ITEM_TYPE_TRAPPER,
						'value_type' => ITEM_VALUE_TYPE_UINT64,
						'delay' => 0
					],
					[
						'name' => 'Information',
						'key_' => 'information',
						'type' => ITEM_TYPE_TRAPPER,
						'value_type' => ITEM_VALUE_TYPE_UINT64,
						'delay' => 0
					],
					[
						'name' => 'Warning',
						'key_' => 'warning',
						'type' => ITEM_TYPE_TRAPPER,
						'value_type' => ITEM_VALUE_TYPE_UINT64,
						'delay' => 0
					],
					[
						'name' => 'Average',
						'key_' => 'average',
						'type' => ITEM_TYPE_TRAPPER,
						'value_type' => ITEM_VALUE_TYPE_UINT64,
						'delay' => 0
					],
					[
						'name' => 'High',
						'key_' => 'high',
						'type' => ITEM_TYPE_TRAPPER,
						'value_type' => ITEM_VALUE_TYPE_UINT64,
						'delay' => 0
					],
					[
						'name' => 'Disaster',
						'key_' => 'disaster',
						'type' => ITEM_TYPE_TRAPPER,
						'value_type' => ITEM_VALUE_TYPE_UINT64,
						'delay' => 0
					]
				]
			]
		]);
		self::$itemids = $response['itemids'];

		CDataHelper::call('trigger.create', [
			[
				'description' => 'Not_classified_trigger',
				'expression' => 'last(/Host for alarm item/not_classified)=0',
				'priority' => TRIGGER_SEVERITY_NOT_CLASSIFIED,
				'manual_close' => 1
			],
			[
				'description' => 'Not_classified_trigger_2',
				'expression' => 'last(/Host for alarm item/not_classified)=1',
				'priority' => TRIGGER_SEVERITY_NOT_CLASSIFIED,
				'manual_close' => 1
			],
			[
				'description' => 'Not_classified_trigger_3',
				'expression' => 'last(/Host for alarm item/not_classified)=1',
				'priority' => TRIGGER_SEVERITY_NOT_CLASSIFIED,
				'manual_close' => 1
			],
			[
				'description' => 'Not_classified_trigger_4',
				'expression' => 'last(/Host for alarm item/not_classified)=2',
				'priority' => TRIGGER_SEVERITY_NOT_CLASSIFIED,
				'manual_close' => 1
			],
			[
				'description' => 'Information_trigger',
				'expression' => 'last(/Host for alarm item/information)=1',
				'priority' => TRIGGER_SEVERITY_INFORMATION,
				'manual_close' => 1
			],
			[
				'description' => 'Warning_trigger',
				'expression' => 'last(/Host for alarm item/warning)=2',
				'priority' => TRIGGER_SEVERITY_WARNING,
				'manual_close' => 1
			],
			[
				'description' => 'Average_trigger',
				'expression' => 'last(/Host for alarm item/average)=3',
				'priority' => TRIGGER_SEVERITY_AVERAGE,
				'manual_close' => 1
			],
			[
				'description' => 'High_trigger',
				'expression' => 'last(/Host for alarm item/high)=4',
				'priority' => TRIGGER_SEVERITY_HIGH,
				'manual_close' => 1
			],
			[
				'description' => 'Disaster_trigger',
				'expression' => 'last(/Host for alarm item/disaster)=5',
				'priority' => TRIGGER_SEVERITY_DISASTER,
				'manual_close' => 1
			]
		]);
		self::$triggersid = CDataHelper::getIds('description');

		// Enable Alarm Notification display for user.
		DBexecute('INSERT INTO profiles (profileid, userid, idx, value_str, source, type)'.
				' VALUES (555,1,'.zbx_dbstr('web.messages').',1,'.zbx_dbstr('enabled').',3)');
	}

	/**
	 * Check Alarm notification overlay dialog  layout.
	 */
	public function testFormAlarmNotification_Layout() {
		$this->page->login()->open('zabbix.php?action=problem.view')->waitUntilReady();
		$this->page->assertTitle('Problems');
		$this->page->assertHeader('Problems');

		// Trigger problem.
		CDBHelper::setTriggerProblem('Not_classified_trigger', TRIGGER_VALUE_TRUE);

		// Find appeared Alarm notification overlay dialog.
		$this->page->refresh()->waitUntilReady();
		$alarm_dialog = $this->query('xpath://div[@class="overlay-dialogue notif ui-draggable"]')->asOverlayDialog()->
				waitUntilPresent()->one();

		// Check that Problem on text exists.
		$this->assertEquals('Problem on Host for alarm item', $alarm_dialog->query('xpath:.//h4')->one()->getText());

		// Check that link for host and trigger filtering works.
		foreach (['Hosts' => 'Host for alarm item', 'Triggers' => 'Not_classified_trigger'] as $field => $name) {
			$this->assertTrue($alarm_dialog->query('link', $name)->one()->isClickable());
			$alarm_dialog->query('link', $name)->one()->click();
			$this->page->waitUntilReady();

			// Check that opens Monitoring->Problems page and correct values filtered.
			$this->page->assertTitle('Problems');
			$this->page->assertHeader('Problems');
			$form = $this->query('name:zbx_filter')->asForm()->one();

			if ($field === 'Triggers') {
				$name = 'Host for alarm item: '.$name;
			}
			$form->checkValue([$field => $name]);
		}

		// Check that after clicking on time - Event page opens.
		$alarm_dialog->query('xpath:.//a[contains(@href, "tr_events")]')->one()->click();
		$this->page->waitUntilReady();
		$this->page->assertTitle('Event details');
		$this->page->assertHeader('Event details');

		// Check displayed icons.
		foreach (['Mute' => 'btn-sound', 'Snooze' => 'btn-alarm'] as $button => $class) {
			$selector = 'xpath:.//button[@title='.CXPathHelper::escapeQuotes($button).']';

			// Check that buttons exists and class says that button is ON.
			$this->assertTrue($alarm_dialog->query($selector)->exists());
			$this->assertEquals($class.'-on', $alarm_dialog->query($selector)->one()->getAttribute('class'));

			if ($button === 'Mute') {
				// After clicking on button it changes status to off and become Unmute.
				$alarm_dialog->query($selector)->one()->click();
				$alarm_dialog->query('xpath:.//button[@title="Unmute"]')->waitUntilVisible()->one();
				$this->assertEquals($class.'-off', $alarm_dialog->query('xpath:.//button[@title="Unmute"]')->
						one()->getAttribute('class')
				);

				// Check that after clicking on Unmute button, Mute icon changed back.
				$alarm_dialog->query('xpath:.//button[@title="Unmute"]')->one()->click();
				$alarm_dialog->query($selector)->waitUntilVisible()->one();
				$this->assertEquals($class.'-on', $alarm_dialog->query($selector)->one()->getAttribute('class'));
			}
			else {
				// Check that after clicking second time on already Snoozed button, it doesn't change status.
				for ($i = 0; $i <=1; $i++) {
					$alarm_dialog->query($selector)->one()->click();
					$this->assertTrue($alarm_dialog->query($selector)->exists());
					$this->assertEquals($class.'-off', $alarm_dialog->query($selector)->one()->getAttribute('class'));
				}
			}
		}

		// Check close button.
		$alarm_dialog->query('xpath:.//button[@title="Close"]')->one()->click();
		$alarm_dialog->ensureNotPresent();
	}

	public static function getDisplayedAlarmsData() {
		return [
			[
				[
					'trigger_name' => ['Information_trigger']
				]
			],
			[
				[
					'trigger_name' => ['Information_trigger']
				]
			]
		];
	}


	/**
	 * @dataProvider getDisplayedAlarmsData
	 */
	public function testFormAlarmNotification_DisplayedAlarms($data) {
		$this->page->login()->open('zabbix.php?action=problem.view')->waitUntilReady();

		// Trigger problem.
		foreach ($data['trigger_name'] as $trigger_name) {
			CDBHelper::setTriggerProblem($trigger_name, TRIGGER_VALUE_TRUE);
		}

		// Find appeared Alarm notification overlay dialog.
		$this->page->refresh()->waitUntilReady();
		$alarm_dialog = $this->query('xpath://div[@class="overlay-dialogue notif ui-draggable"]')->asOverlayDialog()->
				waitUntilPresent()->one();

		foreach ($data['trigger_name'] as $trigger_name) {
			$this->assertEquals('Problem on Host for alarm item', $alarm_dialog->query('xpath:.//h4')->one()->getText());
			$this->assertTrue($alarm_dialog->query('link', $trigger_name)->one()->isClickable());
		}

		// Check close button.
		$alarm_dialog->query('xpath:.//button[@title="Close"]')->one()->click();
		$alarm_dialog->ensureNotPresent();
	}
}
