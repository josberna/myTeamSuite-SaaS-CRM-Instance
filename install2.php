<?php 
include_once('vtlib/Vtiger/Module.php');
include_once('vtlib/Vtiger/Menu.php');
// Turn on debugging level
$Vtiger_Utils_Log = true;
// Create module instance and save it first
$module = new Vtiger_Module();
$module->name = 'SFEligibleOpportunity';
$module->label = 'Eligible Oppty';
$module->save();
// Initialize all the tables required
$module->initTables();
/**
 * Creates the following table:
 * vtiger_payslip  (payslipid INTEGER)
 * vtiger_payslipcf(payslipid INTEGER PRIMARY KEY)
 * vtiger_payslipgrouprel((payslipid INTEGER PRIMARY KEY, groupname VARCHAR(100))
 */
// Add the module to the Menu (entry point from UI)
$menu = Vtiger_Menu::getInstance('Sales Forecast');
$menu->addModule($module);
// Add the basic module block
$block1 = new Vtiger_Block();
$block1->label = 'LBL_SFEligibleOpportunity_INFORMATION';
$module->addBlock($block1);
// Add custom block (required to support Custom Fields)
$block2 = new Vtiger_Block();
$block2->label = 'LBL_CUSTOM_INFORMATION';
$module->addBlock($block2);
/** Create required fields and add to the block */
$field1 = new Vtiger_Field();
$field1->name = 'SFEligibleOpportunityName';
$field1->table = $module->basetable;
$field1->column = 'forecastname';
$field1->columntype = 'VARCHAR(255)';
$field1->uitype = 2;
$field1->typeofdata = 'V~M';
$block1->addField($field1); /** Creates the field and adds to block */
// Set at-least one field to identifier of module record
$module->setEntityIdentifier($field1);
$field2 = new Vtiger_Field();
$field2->name = 'SFEligibleOpportunity';
$field2->label = 'Eligible Opportunity'; 
$field2->columntype = 'VARCHAR(100)';
$field2->uitype = 15;
$field2->typeofdata = 'V~O';// Varchar~Optional
$block1->addField($field2); /** table and column are automatically set */
$field2->setPicklistValues( Array ('Employee', 'Trainee') );
$field3 = new Vtiger_Field();
$field3->name = 'Month';
$field3->uitype = 23;
$field3->typeofdata = 'D~M'; // Date~Mandatory
$block1->addField($field3);  /** table, column, label, set to default values */
$field4 = new Vtiger_Field();
$field4->name = 'LinkTo';
$field4->label= 'Link To';
$field4->table = 'vtiger_SFEligibleOpportunity';
$field4->column = 'linkto';
$field4->columntype = 'VARCHAR(100)';
$field4->uitype = 10;
$field4->typeofdata = 'V~O';
$field4->helpinfo = 'Relate to an existing contact';
$block1->addField($field4);
$field4->setRelatedModules(Array('Contacts'));
/** Common fields that should be in every module, linked to vtiger CRM core table 
*/
$field5 = new Vtiger_Field();
$field5->name = 'assigned_user_id';
$field5->label = 'Assigned To';
$field5->table = 'vtiger_crmentity'; 
$field5->column = 'smownerid';
$field5->uitype = 53;
$field5->typeofdata = 'V~M';
$block1->addField($field5);
$field6 = new Vtiger_Field();
$field6->name = 'CreatedTime';
$field6->label= 'Created Time';
$field6->table = 'vtiger_crmentity';
$field6->column = 'createdtime';
$field6->uitype = 70;
$field6->typeofdata = 'T~O';
$field6->displaytype= 2;
$block1->addField($field6);
$field7 = new Vtiger_Field();
$field7->name = 'ModifiedTime';
$field7->label= 'Modified Time';
$field7->table = 'vtiger_crmentity';
$field7->column = 'modifiedtime';
$field7->uitype = 70;
$field7->typeofdata = 'T~O';
$field7->displaytype= 2;
$block1->addField($field7);
/** END */
// Create default custom filter (mandatory)
$filter1 = new Vtiger_Filter();
$filter1->name = 'All';
$filter1->isdefault = true;
$module->addFilter($filter1);
// Add fields to the filter created
$filter1->addField($field1)->addField($field2, 1)->addField($field5, 2);
// Create one more filter
$filter2 = new Vtiger_Filter();
$filter2->name = 'All2';
$module->addFilter($filter2);
// Add fields to the filter
$filter2->addField($field1);
$filter2->addField($field2, 1);
// Add rule to the filter field
$filter2->addRule($field1, 'CONTAINS', 'Test');
/** Associate other modules to this module */
$module->setRelatedList(Vtiger_Module::getInstance('Potentials'), 'Potentials', 
Array('ADD','SELECT'));
/** Set sharing access of this module */
$module->setDefaultSharing('Private'); 
/** Enable and Disable available tools */
$module->enableTools(Array('Import', 'Export'));
$module->disableTools('Merge');

$moduleInstance = Vtiger_Module::getInstance('SFEligibleOpportunity');
$moduleInstance->initWebservice();
?>