<?php

/**
 * Module combodo-flow-map
 *
 * @copyright  Copyright (C) 2010-2024 Combodo SAS
 * @license    https://opensource.org/licenses/AGPL-3.0
 */

Dict::Add('ZH CN', 'Chinese', '简体中文', [

	'Relation:dataflows/Description'    => '配置项之间的数据流',
	'Relation:dataflows/DownStream'     => '出站数据流...',
	'Relation:dataflows/DownStream+'    => 'Outbound flows map from~~',
	'Relation:dataflows/UpStream'       => '入站数据流...',
	'Relation:dataflows/UpStream+'      => 'Inbound flows map to~~',

	'Class:FunctionalCI/Attribute:dataflows' => '数据流',
	'Class:FunctionalCI/Attribute:dataflows+' => '该对象作为源或目标的数据流',
	'FunctionalCI:DataFlow:Title' => '数据流',
	'FunctionalCI:DataFlow:Inbound' => '入站数据流',
	'FunctionalCI:DataFlow:Outbound' => '出站数据流',

	'DataFlow:moreinfo' => '数据流详情',

	'Class:DataFlow' => '数据流',
	'Class:DataFlow+' => 'For application flow for example~~',
	'Class:DataFlow/ComplementaryName' => '%1$s - %2$s',
	'Class:DataFlow/Attribute:name' => '名称',
	'Class:DataFlow/Attribute:name+' => '已传输的数据',
	'Class:DataFlow/Attribute:source_id' => '数据源',
	'Class:DataFlow/Attribute:source_id+' => '数据流的源头配置项',
	'Class:DataFlow/Attribute:source_impact' => '数据源影响?',
	'Class:DataFlow/Attribute:source_impact+' => '数据源是否影响数据流?',
	'Class:DataFlow/Attribute:source_impact/Value:yes' => '是',
	'Class:DataFlow/Attribute:source_impact/Value:yes+' => '如果数据源失效，数据流将受到影响',
	'Class:DataFlow/Attribute:source_impact/Value:no' => '否',
	'Class:DataFlow/Attribute:source_impact/Value:no+' => '如果数据源失效，数据流不受影响',
	'Class:DataFlow/Attribute:destination_id' => '目标',
	'Class:DataFlow/Attribute:destination_id+' => '数据流的目标配置项',
	'Class:DataFlow/Attribute:destination_impact' => '目标影响',
	'Class:DataFlow/Attribute:destination_impact+' => '目标是否受数据流影响?',
	'Class:DataFlow/Attribute:destination_impact/Value:yes' => '是',
	'Class:DataFlow/Attribute:destination_impact/Value:yes+' => '如果数据流停止，目标将受到影响',
	'Class:DataFlow/Attribute:destination_impact/Value:no' => '否',
	'Class:DataFlow/Attribute:destination_impact/Value:no+' => '如果数据流停止，目标不受影响',
	'Class:DataFlow/Attribute:dataflowtype_id' => '数据流类型',
	'Class:DataFlow/Attribute:dataflowtype_id+' => '数据流的分类',
	'Class:DataFlow/Attribute:dataflowprotocol_id' => 'Flow protocol~~',
	'Class:DataFlow/Attribute:dataflowprotocol_id+' => 'Values defined in a typology of Data Flow Protocol~~',
	'Class:DataFlow/Attribute:documentation_url' => 'Documentation URL~~',
	'Class:DataFlow/Attribute:documentation_url+' => 'URL to the documentation of the data flow~~',
	'Class:DataFlow/Attribute:last_change_date' => 'Last change date~~',
	'Class:DataFlow/Attribute:last_change_date+' => 'Last time the software or configuration of the Data Flow was updated~~',
	'Class:DataFlow/Attribute:status' => '状态',
	'Class:DataFlow/Attribute:status+' => '',
	'Class:DataFlow/Attribute:status/Value:active' => '启用',
	'Class:DataFlow/Attribute:status/Value:inactive' => '停用',
	'Class:DataFlow/Attribute:execution_frequency' => '执行频率',
	'Class:DataFlow/Attribute:execution_frequency+' => '数据流执行的频率',
	'Class:DataFlow/Attribute:execution_frequency/Value:realtime' => '实时',
	'Class:DataFlow/Attribute:execution_frequency/Value:realtime+' => '',
	'Class:DataFlow/Attribute:execution_frequency/Value:ondemand' => '按需',
	'Class:DataFlow/Attribute:execution_frequency/Value:ondemand+' => '即时执行，不按计划进行',
	'Class:DataFlow/Attribute:execution_frequency/Value:hourly' => '每小时',
	'Class:DataFlow/Attribute:execution_frequency/Value:hourly+' => '',
	'Class:DataFlow/Attribute:execution_frequency/Value:daily' => '每天',
	'Class:DataFlow/Attribute:execution_frequency/Value:daily+' => '',
	'Class:DataFlow/Attribute:execution_frequency/Value:weekly' => '每周',
	'Class:DataFlow/Attribute:execution_frequency/Value:weekly+' => '',
	'Class:DataFlow/Attribute:execution_frequency/Value:monthly' => '每月',
	'Class:DataFlow/Attribute:execution_frequency/Value:monthly+' => '',
	'Class:DataFlow/Attribute:execution_frequency/Value:yearly' => '每年',
	'Class:DataFlow/Attribute:execution_frequency/Value:yearly+' => '',
	'Class:DataFlow/Attribute:documents_list+' => '例如: 技术规范, 操作手册等.',
	'Class:DataFlow/Attribute:contacts_list+' => '例如: 数据流所有者, 技术支持等.',
	'Class:DataFlow/Error:CheckSource' => '无法指定自己为数据源. 请选择其它配置项作为数据源,而不是选择 %1$s',
	'Class:DataFlow/Error:CheckDestination' => '无法指定自己为数据目标. 请选择其它配置项作为数据目标,而不是选择 %1$s',

	'Class:DataFlowType' => '数据流类型',
	'Class:DataFlowType+' => '数据流的分类',

	'Class:DataFlowProtocol' => 'Data Flow Protocol',
	'Class:DataFlowProtocol+' => 'Typology of Data Flow Protocol',

]);
