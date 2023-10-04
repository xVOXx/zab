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

require_once dirname(__FILE__).'/testGeneric.php';
require_once dirname(__FILE__).'/testPageDashboardWidgets.php';
require_once dirname(__FILE__).'/testPageLatestData.php';
require_once dirname(__FILE__).'/problems/testFormUpdateProblem.php';
require_once dirname(__FILE__).'/problems/testPageProblems.php';
require_once dirname(__FILE__).'/testPageActions.php';
require_once dirname(__FILE__).'/testPageAdministrationDMProxies.php';
require_once dirname(__FILE__).'/testFormAdministrationGeneralAutoregistration.php';
require_once dirname(__FILE__).'/testPageAdministrationGeneralIconMapping.php';
require_once dirname(__FILE__).'/testPageAdministrationGeneralImages.php';
require_once dirname(__FILE__).'/testPageAdministrationGeneralModules.php';
require_once dirname(__FILE__).'/testPageAdministrationGeneralRegexp.php';
require_once dirname(__FILE__).'/mediaTypes/testPageAdministrationMediaTypes.php';
require_once dirname(__FILE__).'/testPageApiTokensAdministrationGeneral.php';
require_once dirname(__FILE__).'/testPageApiTokensUserSettings.php';
require_once dirname(__FILE__).'/testPageAvailabilityReport.php';
require_once dirname(__FILE__).'/testPageDashboardList.php';
require_once dirname(__FILE__).'/eventCorrelation/testPageEventCorrelation.php';
require_once dirname(__FILE__).'/graphs/testFormGraph.php';
require_once dirname(__FILE__).'/graphs/testFormGraphPrototype.php';
require_once dirname(__FILE__).'/graphs/testGraphAxis.php';
require_once dirname(__FILE__).'/graphs/testInheritanceGraph.php';
require_once dirname(__FILE__).'/graphs/testInheritanceGraphPrototype.php';
require_once dirname(__FILE__).'/graphs/testPageGraphPrototypes.php';
require_once dirname(__FILE__).'/graphs/testPageHostGraph.php';
require_once dirname(__FILE__).'/graphs/testPageMonitoringHostsGraph.php';
require_once dirname(__FILE__).'/testPageHistory.php';
require_once dirname(__FILE__).'/testPageHostInterfaces.php';
require_once dirname(__FILE__).'/testPageHostPrototypes.php';
require_once dirname(__FILE__).'/testPageHosts.php';
require_once dirname(__FILE__).'/testPageInventory.php';
require_once dirname(__FILE__).'/items/testPageItems.php';
require_once dirname(__FILE__).'/items/testPageItemPrototypes.php';
require_once dirname(__FILE__).'/testPageTriggers.php';
require_once dirname(__FILE__).'/testPageTriggerUrl.php';
require_once dirname(__FILE__).'/testPageTriggerPrototypes.php';
require_once dirname(__FILE__).'/maintenance/testPageMaintenance.php';
require_once dirname(__FILE__).'/testPageMaps.php';
require_once dirname(__FILE__).'/testPageMassUpdateItems.php';
require_once dirname(__FILE__).'/testPageMassUpdateItemPrototypes.php';
require_once dirname(__FILE__).'/testPageMonitoringHosts.php';
require_once dirname(__FILE__).'/networkDiscovery/testPageNetworkDiscovery.php';
require_once dirname(__FILE__).'/lld/testPageLowLevelDiscovery.php';
require_once dirname(__FILE__).'/testPasswordComplexity.php';
/*
require_once dirname(__FILE__).'/testPageQueueDetails.php';
require_once dirname(__FILE__).'/testPageQueueOverview.php';
require_once dirname(__FILE__).'/testPageQueueOverviewByProxy.php';
*/
require_once dirname(__FILE__).'/testPageSearch.php';
require_once dirname(__FILE__).'/testPageStatusOfZabbix.php';
require_once dirname(__FILE__).'/testPageTemplates.php';
require_once dirname(__FILE__).'/testPageTriggerDescription.php';
require_once dirname(__FILE__).'/testPageUserGroups.php';
require_once dirname(__FILE__).'/users/testPageUsers.php';
require_once dirname(__FILE__).'/testExpandExpressionMacros.php';
require_once dirname(__FILE__).'/testFormAction.php';
require_once dirname(__FILE__).'/testFormAdministrationAuthenticationHttp.php';
require_once dirname(__FILE__).'/testFormAdministrationAuthenticationLdap.php';
require_once dirname(__FILE__).'/testFormAdministrationAuthenticationSaml.php';
require_once dirname(__FILE__).'/testFormAdministrationDMProxies.php';
require_once dirname(__FILE__).'/testFormAdministrationGeneralAuditLog.php';
require_once dirname(__FILE__).'/testFormAdministrationGeneralGUI.php';
require_once dirname(__FILE__).'/testFormAdministrationGeneralHousekeeper.php';
require_once dirname(__FILE__).'/testFormAdministrationGeneralIconMapping.php';
//require_once dirname(__FILE__).'/testFormAdministrationGeneralImages.php';
require_once dirname(__FILE__).'/testFormAdministrationGeneralMacros.php';
require_once dirname(__FILE__).'/testFormAdministrationGeneralOtherParams.php';
require_once dirname(__FILE__).'/testFormAdministrationGeneralRegexp.php';
require_once dirname(__FILE__).'/testFormAdministrationGeneralTrigDisplOptions.php';
require_once dirname(__FILE__).'/mediaTypes/testFormAdministrationMediaTypes.php';
require_once dirname(__FILE__).'/mediaTypes/testFormAdministrationMediaTypeMessageTemplates.php';
require_once dirname(__FILE__).'/mediaTypes/testFormAdministrationMediaTypeWebhook.php';
require_once dirname(__FILE__).'/testFormAdministrationUserGroups.php';
require_once dirname(__FILE__).'/testFormApiTokensAdministrationGeneral.php';
require_once dirname(__FILE__).'/testFormApiTokensUserSettings.php';
require_once dirname(__FILE__).'/eventCorrelation/testFormEventCorrelation.php';
require_once dirname(__FILE__).'/filterTabs/testFormFilterHosts.php';
require_once dirname(__FILE__).'/filterTabs/testFormFilterLatestData.php';
require_once dirname(__FILE__).'/filterTabs/testFormFilterProblems.php';
require_once dirname(__FILE__).'/hosts/testFormHostConfiguration.php';
require_once dirname(__FILE__).'/hosts/testFormHostMonitoring.php';
require_once dirname(__FILE__).'/hosts/testFormHostStandalone.php';
require_once dirname(__FILE__).'/testFormHostLinkTemplates.php';
require_once dirname(__FILE__).'/testFormHostPrototype.php';
require_once dirname(__FILE__).'/items/testFormItem.php';
require_once dirname(__FILE__).'/items/testFormItemHttpAgent.php';
require_once dirname(__FILE__).'/items/testFormItemPrototype.php';
require_once dirname(__FILE__).'/items/testFormTestItem.php';
require_once dirname(__FILE__).'/items/testFormTestItemPrototype.php';
require_once dirname(__FILE__).'/lld/testFormTestLowLevelDiscovery.php';
require_once dirname(__FILE__).'/testFormLogin.php';
require_once dirname(__FILE__).'/lld/testFormLowLevelDiscovery.php';
require_once dirname(__FILE__).'/lld/testFormLowLevelDiscoveryOverrides.php';
require_once dirname(__FILE__).'/testFormMacrosHost.php';
require_once dirname(__FILE__).'/testFormMacrosHostPrototype.php';
require_once dirname(__FILE__).'/testFormMacrosTemplate.php';
require_once dirname(__FILE__).'/maintenance/testFormMaintenance.php';
require_once dirname(__FILE__).'/testFormMap.php';
require_once dirname(__FILE__).'/networkDiscovery/testFormNetworkDiscovery.php';
require_once dirname(__FILE__).'/preprocessing/testFormPreprocessingCloneHost.php';
require_once dirname(__FILE__).'/preprocessing/testFormPreprocessingCloneTemplate.php';
require_once dirname(__FILE__).'/preprocessing/testFormPreprocessingItem.php';
require_once dirname(__FILE__).'/preprocessing/testFormPreprocessingItemPrototype.php';
require_once dirname(__FILE__).'/preprocessing/testFormPreprocessingLowLevelDiscovery.php';
require_once dirname(__FILE__).'/preprocessing/testFormPreprocessingTest.php';
require_once dirname(__FILE__).'/scripts/testFormAdministrationScripts.php';
require_once dirname(__FILE__).'/scripts/testPageAdministrationScripts.php';
require_once dirname(__FILE__).'/services/testFormServicesServices.php';
require_once dirname(__FILE__).'/services/testPageServicesServices.php';
require_once dirname(__FILE__).'/services/testPageServicesServicesMassUpdate.php';
require_once dirname(__FILE__).'/sla/testFormServicesSla.php';
require_once dirname(__FILE__).'/sla/testPageServicesSla.php';
require_once dirname(__FILE__).'/sla/testPageServicesSlaReport.php';
require_once dirname(__FILE__).'/testFormSetup.php';
require_once dirname(__FILE__).'/testFormSysmap.php';
require_once dirname(__FILE__).'/testFormTabIndicators.php';
require_once dirname(__FILE__).'/tags/testFormTagsHost.php';
require_once dirname(__FILE__).'/tags/testFormTagsHostPrototype.php';
require_once dirname(__FILE__).'/tags/testFormTagsServices.php';
require_once dirname(__FILE__).'/tags/testFormTagsServicesProblemTags.php';
require_once dirname(__FILE__).'/tags/testFormTagsItem.php';
require_once dirname(__FILE__).'/tags/testFormTagsItemPrototype.php';
require_once dirname(__FILE__).'/tags/testFormTagsTemplate.php';
require_once dirname(__FILE__).'/tags/testFormTagsTrigger.php';
require_once dirname(__FILE__).'/tags/testFormTagsTriggerPrototype.php';
require_once dirname(__FILE__).'/tags/testFormTagsWeb.php';
require_once dirname(__FILE__).'/testFormTrigger.php';
require_once dirname(__FILE__).'/testFormTemplate.php';
require_once dirname(__FILE__).'/testFormTriggerPrototype.php';
require_once dirname(__FILE__).'/users/testFormUser.php';
require_once dirname(__FILE__).'/users/testFormUserMedia.php';
require_once dirname(__FILE__).'/users/testFormUserProfile.php';
require_once dirname(__FILE__).'/users/testFormUserPermissions.php';
require_once dirname(__FILE__).'/testFormValueMappingsHost.php';
require_once dirname(__FILE__).'/testFormValueMappingsTemplate.php';
require_once dirname(__FILE__).'/roles/testFormUserRoles.php';
require_once dirname(__FILE__).'/webScenarios/testFormWebScenario.php';
require_once dirname(__FILE__).'/webScenarios/testFormWebScenarioStep.php';
require_once dirname(__FILE__).'/webScenarios/testPageMonitoringWeb.php';
require_once dirname(__FILE__).'/webScenarios/testInheritanceWeb.php';
require_once dirname(__FILE__).'/webScenarios/testPageMonitoringWebDetails.php';
require_once dirname(__FILE__).'/items/testFormulaCalculatedItem.php';
require_once dirname(__FILE__).'/items/testFormulaCalculatedItemPrototype.php';
require_once dirname(__FILE__).'/testPageBrowserWarning.php';
require_once dirname(__FILE__).'/items/testInheritanceItem.php';
require_once dirname(__FILE__).'/testInheritanceTrigger.php';
require_once dirname(__FILE__).'/lld/testInheritanceDiscoveryRule.php';
require_once dirname(__FILE__).'/items/testInheritanceItemPrototype.php';
require_once dirname(__FILE__).'/items/testItemTypeSelection.php';
require_once dirname(__FILE__).'/testInheritanceTriggerPrototype.php';
require_once dirname(__FILE__).'/testInheritanceHostPrototype.php';
require_once dirname(__FILE__).'/testLanguage.php';
require_once dirname(__FILE__).'/testMultiselect.php';
require_once dirname(__FILE__).'/testTagBasedPermissions.php';
require_once dirname(__FILE__).'/testTemplateInheritance.php';
require_once dirname(__FILE__).'/testTimezone.php';
require_once dirname(__FILE__).'/testTriggerDependencies.php';
require_once dirname(__FILE__).'/testTriggerExpressions.php';
require_once dirname(__FILE__).'/testSidebarMenu.php';
require_once dirname(__FILE__).'/testUrlParameters.php';
require_once dirname(__FILE__).'/testUrlUserPermissions.php';
require_once dirname(__FILE__).'/testZBX6648.php';
require_once dirname(__FILE__).'/testZBX6663.php';
require_once dirname(__FILE__).'/roles/testPageUserRoles.php';
require_once dirname(__FILE__).'/roles/testUserRolesPermissions.php';
require_once dirname(__FILE__).'/dashboard/testDashboardClockWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardCopyWidgets.php';
require_once dirname(__FILE__).'/dashboard/testDashboardGraphPrototypeWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardGeomapWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardDynamicItemWidgets.php';
require_once dirname(__FILE__).'/dashboard/testDashboardFavoriteGraphsWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardFavoriteMapsWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardForm.php';
require_once dirname(__FILE__).'/dashboard/testDashboardViewMode.php';
require_once dirname(__FILE__).'/dashboard/testDashboardGraphWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardHostAvailabilityWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardProblemsBySeverityWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardItemValueWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardSlaReportWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardSystemInformationWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardTopHostsWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardTriggerOverviewWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardURLWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardPages.php';
require_once dirname(__FILE__).'/dashboard/testDashboardPlainTextWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardProblemsWidget.php';
require_once dirname(__FILE__).'/dashboard/testDashboardProblemsWidgetDisplay.php';
require_once dirname(__FILE__).'/dashboard/testFormTemplateDashboards.php';
require_once dirname(__FILE__).'/dashboard/testPageTemplateDashboards.php';
require_once dirname(__FILE__).'/geomaps/testFormAdministrationGeneralGeomaps.php';
require_once dirname(__FILE__).'/geomaps/testGeomapWidgetScreenshots.php';
require_once dirname(__FILE__).'/hostGroups/testFormHostGroup.php';
require_once dirname(__FILE__).'/hostGroups/testFormHostGroupSearchPage.php';
require_once dirname(__FILE__).'/hostGroups/testPageHostGroups.php';
require_once dirname(__FILE__).'/reports/testPageReportsActionLog.php';
require_once dirname(__FILE__).'/reports/testPageReportsAudit.php';
require_once dirname(__FILE__).'/reports/testPageReportsNotifications.php';
require_once dirname(__FILE__).'/reports/testPageReportsSystemInformation.php';
require_once dirname(__FILE__).'/reports/testPageReportsTriggerTop.php';
require_once dirname(__FILE__).'/reports/testFormScheduledReport.php';
require_once dirname(__FILE__).'/reports/testPageScheduledReport.php';
require_once dirname(__FILE__).'/reports/testScheduledReportPermissions.php';
require_once dirname(__FILE__).'/testSID.php';

use PHPUnit\Framework\TestSuite;

class SeleniumTests {
	public static function suite() {
		$suite = new TestSuite('selenium');

		$suite->addTestSuite('testGeneric');
		$suite->addTestSuite('testPageActions');
		$suite->addTestSuite('testPageAdministrationDMProxies');
		$suite->addTestSuite('testFormAdministrationGeneralAutoregistration');
		$suite->addTestSuite('testPageAdministrationGeneralIconMapping');
		$suite->addTestSuite('testPageAdministrationGeneralImages');
		$suite->addTestSuite('testPageAdministrationGeneralModules');
		$suite->addTestSuite('testPageAdministrationGeneralRegexp');
		$suite->addTestSuite('testPageAdministrationMediaTypes');
		$suite->addTestSuite('testPageAdministrationScripts');
		$suite->addTestSuite('testPageApiTokensAdministrationGeneral');
		$suite->addTestSuite('testPageApiTokensUserSettings');
		$suite->addTestSuite('testPageAvailabilityReport');
		$suite->addTestSuite('testPageDashboardList');
		$suite->addTestSuite('testPageDashboardWidgets');
		$suite->addTestSuite('testPageEventCorrelation');
		$suite->addTestSuite('testFormGraph');
		$suite->addTestSuite('testFormGraphPrototype');
		$suite->addTestSuite('testGraphAxis');
		$suite->addTestSuite('testInheritanceGraph');
		$suite->addTestSuite('testInheritanceGraphPrototype');
		$suite->addTestSuite('testPageGraphPrototypes');
		$suite->addTestSuite('testFormUpdateProblem');
		$suite->addTestSuite('testPageProblems');
		$suite->addTestSuite('testPageHistory');
		$suite->addTestSuite('testPageHostGraph');
		$suite->addTestSuite('testPageHostInterfaces');
		$suite->addTestSuite('testPageHostPrototypes');
		$suite->addTestSuite('testPageHosts');
		$suite->addTestSuite('testPageHostGroups');
		$suite->addTestSuite('testPageInventory');
		$suite->addTestSuite('testPageItems');
		$suite->addTestSuite('testPageItemPrototypes');
		$suite->addTestSuite('testPageTriggers');
		$suite->addTestSuite('testPageTriggerDescription');
		$suite->addTestSuite('testPageTriggerUrl');
		$suite->addTestSuite('testPageTriggerPrototypes');
		$suite->addTestSuite('testPageLatestData');
		$suite->addTestSuite('testPageLowLevelDiscovery');
		$suite->addTestSuite('testPageMaintenance');
		$suite->addTestSuite('testPageMaps');
		$suite->addTestSuite('testPageMassUpdateItems');
		$suite->addTestSuite('testPageMassUpdateItemPrototypes');
		$suite->addTestSuite('testPageMonitoringHosts');
		$suite->addTestSuite('testPageMonitoringHostsGraph');
		$suite->addTestSuite('testPageMonitoringWebDetails');
		$suite->addTestSuite('testPageNetworkDiscovery');
/*
		$suite->addTestSuite('testPageQueueDetails');
		$suite->addTestSuite('testPageQueueOverview');
		$suite->addTestSuite('testPageQueueOverviewByProxy');
*/
		$suite->addTestSuite('testPageReportsActionLog');
		$suite->addTestSuite('testPageReportsAudit');
		$suite->addTestSuite('testPageReportsNotifications');
		$suite->addTestSuite('testPageReportsSystemInformation');
		$suite->addTestSuite('testPageReportsTriggerTop');
		$suite->addTestSuite('testPageSearch');
		$suite->addTestSuite('testPageServicesServices');
		$suite->addTestSuite('testPageServicesServicesMassUpdate');
		$suite->addTestSuite('testPageServicesSla');
		$suite->addTestSuite('testPageServicesSlaReport');
		$suite->addTestSuite('testPageStatusOfZabbix');
		$suite->addTestSuite('testPageTemplates');
		$suite->addTestSuite('testPageUserGroups');
		$suite->addTestSuite('testPageUsers');
		$suite->addTestSuite('testPageMonitoringWeb');
		$suite->addTestSuite('testPasswordComplexity');
		$suite->addTestSuite('testExpandExpressionMacros');
		$suite->addTestSuite('testFormAction');
		$suite->addTestSuite('testFormAdministrationAuthenticationSaml');
		$suite->addTestSuite('testFormAdministrationAuthenticationHttp');
		$suite->addTestSuite('testFormAdministrationAuthenticationLdap');
		$suite->addTestSuite('testFormAdministrationDMProxies');
		$suite->addTestSuite('testFormAdministrationGeneralAuditLog');
		$suite->addTestSuite('testFormAdministrationGeneralGUI');
		$suite->addTestSuite('testFormAdministrationGeneralHousekeeper');
		$suite->addTestSuite('testFormAdministrationGeneralIconMapping');
//		$suite->addTestSuite('testFormAdministrationGeneralImages');
		$suite->addTestSuite('testFormAdministrationGeneralMacros');
		$suite->addTestSuite('testFormAdministrationGeneralOtherParams');
		$suite->addTestSuite('testFormAdministrationGeneralRegexp');
		$suite->addTestSuite('testFormAdministrationGeneralTrigDisplOptions');
		$suite->addTestSuite('testFormAdministrationMediaTypes');
		$suite->addTestSuite('testFormAdministrationMediaTypeMessageTemplates');
		$suite->addTestSuite('testFormAdministrationMediaTypeWebhook');
		$suite->addTestSuite('testFormAdministrationScripts');
		$suite->addTestSuite('testFormAdministrationUserGroups');
		$suite->addTestSuite('testFormApiTokensAdministrationGeneral');
		$suite->addTestSuite('testFormApiTokensUserSettings');
		$suite->addTestSuite('testFormEventCorrelation');
		$suite->addTestSuite('testFormFilterHosts');
		$suite->addTestSuite('testFormFilterLatestData');
		$suite->addTestSuite('testFormFilterProblems');
		$suite->addTestSuite('testFormAdministrationGeneralGeomaps');
		$suite->addTestSuite('testGeomapWidgetScreenshots');
		$suite->addTestSuite('testFormHostConfiguration');
		$suite->addTestSuite('testFormHostMonitoring');
		$suite->addTestSuite('testFormHostStandalone');
		$suite->addTestSuite('testFormHostGroup');
		$suite->addTestSuite('testFormHostGroupSearchPage');
		$suite->addTestSuite('testFormHostLinkTemplates');
		$suite->addTestSuite('testFormHostPrototype');
		$suite->addTestSuite('testFormItem');
		$suite->addTestSuite('testFormItemHttpAgent');
		$suite->addTestSuite('testFormItemPrototype');
		$suite->addTestSuite('testFormTestItem');
		$suite->addTestSuite('testFormTestItemPrototype');
		$suite->addTestSuite('testFormTestLowLevelDiscovery');
		$suite->addTestSuite('testFormLogin');
		$suite->addTestSuite('testFormLowLevelDiscovery');
		$suite->addTestSuite('testFormLowLevelDiscoveryOverrides');
		$suite->addTestSuite('testFormMacrosHost');
		$suite->addTestSuite('testFormMacrosHostPrototype');
		$suite->addTestSuite('testFormMacrosTemplate');
		$suite->addTestSuite('testFormMaintenance');
		$suite->addTestSuite('testFormMap');
		$suite->addTestSuite('testFormNetworkDiscovery');
		$suite->addTestSuite('testFormPreprocessingCloneHost');
		$suite->addTestSuite('testFormPreprocessingCloneTemplate');
		$suite->addTestSuite('testFormPreprocessingItem');
		$suite->addTestSuite('testFormPreprocessingItemPrototype');
		$suite->addTestSuite('testFormPreprocessingLowLevelDiscovery');
		$suite->addTestSuite('testFormPreprocessingTest');
		$suite->addTestSuite('testFormServicesServices');
		$suite->addTestSuite('testFormServicesSla');
		$suite->addTestSuite('testFormSetup');
		$suite->addTestSuite('testFormSysmap');
		$suite->addTestSuite('testFormTabIndicators');
		$suite->addTestSuite('testFormTagsHost');
		$suite->addTestSuite('testFormTagsHostPrototype');
		$suite->addTestSuite('testFormTagsServices');
		$suite->addTestSuite('testFormTagsServicesProblemTags');
		$suite->addTestSuite('testFormTagsItem');
		$suite->addTestSuite('testFormTagsItemPrototype');
		$suite->addTestSuite('testFormTagsTemplate');
		$suite->addTestSuite('testFormTagsTrigger');
		$suite->addTestSuite('testFormTagsTriggerPrototype');
		$suite->addTestSuite('testFormTagsWeb');
		$suite->addTestSuite('testFormTemplate');
		$suite->addTestSuite('testFormTrigger');
		$suite->addTestSuite('testFormTriggerPrototype');
		$suite->addTestSuite('testFormUser');
		$suite->addTestSuite('testFormUserMedia');
		$suite->addTestSuite('testFormUserProfile');
		$suite->addTestSuite('testFormUserPermissions');
		$suite->addTestSuite('testFormValueMappingsHost');
		$suite->addTestSuite('testFormValueMappingsTemplate');
		$suite->addTestSuite('testFormUserRoles');
		$suite->addTestSuite('testFormWebScenario');
		$suite->addTestSuite('testFormWebScenarioStep');
		$suite->addTestSuite('testFormulaCalculatedItem');
		$suite->addTestSuite('testFormulaCalculatedItemPrototype');
		$suite->addTestSuite('testPageBrowserWarning');
		$suite->addTestSuite('testInheritanceItem');
		$suite->addTestSuite('testInheritanceTrigger');
		$suite->addTestSuite('testInheritanceWeb');
		$suite->addTestSuite('testInheritanceDiscoveryRule');
		$suite->addTestSuite('testInheritanceHostPrototype');
		$suite->addTestSuite('testInheritanceItemPrototype');
		$suite->addTestSuite('testItemTypeSelection');
		$suite->addTestSuite('testInheritanceTriggerPrototype');
		$suite->addTestSuite('testLanguage');
		$suite->addTestSuite('testMultiselect');
		$suite->addTestSuite('testTagBasedPermissions');
		$suite->addTestSuite('testTemplateInheritance');
		$suite->addTestSuite('testTimezone');
		$suite->addTestSuite('testTriggerDependencies');
		$suite->addTestSuite('testTriggerExpressions');
		$suite->addTestSuite('testSidebarMenu');
		$suite->addTestSuite('testUrlParameters');
		$suite->addTestSuite('testUrlUserPermissions');
		$suite->addTestSuite('testZBX6648');
		$suite->addTestSuite('testZBX6663');
		$suite->addTestSuite('testPageUserRoles');
		$suite->addTestSuite('testUserRolesPermissions');
		$suite->addTestSuite('testDashboardClockWidget');
		$suite->addTestSuite('testDashboardCopyWidgets');
		$suite->addTestSuite('testDashboardGraphPrototypeWidget');
		$suite->addTestSuite('testDashboardGeomapWidget');
		$suite->addTestSuite('testDashboardDynamicItemWidgets');
		$suite->addTestSuite('testDashboardFavoriteGraphsWidget');
		$suite->addTestSuite('testDashboardFavoriteMapsWidget');
		$suite->addTestSuite('testDashboardForm');
		$suite->addTestSuite('testDashboardGraphWidget');
		$suite->addTestSuite('testDashboardHostAvailabilityWidget');
		$suite->addTestSuite('testDashboardProblemsBySeverityWidget');
		$suite->addTestSuite('testDashboardItemValueWidget');
		$suite->addTestSuite('testDashboardSlaReportWidget');
		$suite->addTestSuite('testDashboardSystemInformationWidget');
		$suite->addTestSuite('testDashboardTopHostsWidget');
		$suite->addTestSuite('testDashboardTriggerOverviewWidget');
		$suite->addTestSuite('testDashboardPages');
		$suite->addTestSuite('testDashboardPlainTextWidget');
		$suite->addTestSuite('testDashboardProblemsWidget');
		$suite->addTestSuite('testDashboardProblemsWidgetDisplay');
		$suite->addTestSuite('testDashboardURLWidget');
		$suite->addTestSuite('testDashboardViewMode');
		$suite->addTestSuite('testFormTemplateDashboards');
		$suite->addTestSuite('testPageTemplateDashboards');
		$suite->addTestSuite('testFormScheduledReport');
		$suite->addTestSuite('testPageScheduledReport');
		$suite->addTestSuite('testScheduledReportPermissions');
		$suite->addTestSuite('testSID');

		return $suite;
	}
}
