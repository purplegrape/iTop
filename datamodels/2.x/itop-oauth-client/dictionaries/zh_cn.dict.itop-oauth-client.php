<?php

/**
 * Localized data
 *
 * @copyright Copyright (C) 2010-2024 Combodo SAS
 * @license    https://opensource.org/licenses/AGPL-3.0
 */

Dict::Add('ZH CN', 'Chinese', '简体中文', [
	'Menu:CreateMailbox' => '新建邮箱...',
	'Menu:OAuthClient' => 'OAuth Mail Access~~',
	'Menu:OAuthClient+' => 'Oauth for email access~~',
	'Menu:GenerateTokens' => '生成 Access Token...',
	'Menu:RegenerateTokens' => '重新生成 Access Token...',

	'itop-oauth-client/Operation:CreateMailBox/Title' => '邮箱创建',

	'itop-oauth-client:UsedForSMTP' => '此 OAuth 客户端用于 SMTP',
	'itop-oauth-client:TestSMTP' => '发送测试邮件',
	'itop-oauth-client:MissingOAuthClient' => '用户 %1$s 没有 Oauth 客户端',
	'itop-oauth-client:Message:MissingToken' => '在使用 OAuth 客户端之前生成 Access Token',
	'itop-oauth-client:Message:RegenerateToken' => '重新生成 Access Token 以生效',
	'itop-oauth-client:Message:TokenCreated' => 'Access Token 已生成',
	'itop-oauth-client:Message:TokenRecreated' => 'Access Token 已重新生成',
	'itop-oauth-client:Message:TokenError' => '由于服务器报错, 没有生成 Access Token',

	'OAuthClient:Name/UseForSMTPMustBeUnique' => '用于普通登录 (%1$s) 和用于 SMTP (%2$s) 的组合已被 OAuth 客户端使用',

	'OAuthClient:baseinfo' => '基本信息',
	'OAuthClient:scope' => '使用范围',
]);

//
// Class: OAuthClient
//

Dict::Add('ZH CN', 'Chinese', '简体中文', [
	'Class:OAuthClient' => 'OAuth Mail Access~~',
	'Class:OAuthClient/Attribute:provider' => '提供商',
	'Class:OAuthClient/Attribute:provider+' => '',
	'Class:OAuthClient/Attribute:name' => '登录名',
	'Class:OAuthClient/Attribute:name+' => '通常, 这里填您的邮箱地址',
	'Class:OAuthClient/Attribute:status' => '状态',
	'Class:OAuthClient/Attribute:status+' => '创建后, 通过点击 "生成 Access Token" 来启用 OAuth 客户端',
	'Class:OAuthClient/Attribute:status/Value:active' => '已生成 Access Token',
	'Class:OAuthClient/Attribute:status/Value:inactive' => '没有 Access Token',
	'Class:OAuthClient/Attribute:description' => '描述',
	'Class:OAuthClient/Attribute:description+' => '',
	'Class:OAuthClient/Attribute:client_id' => '客户端id',
	'Class:OAuthClient/Attribute:client_id+' => 'A long string of characters provided by your OAuth2 provider~~',
	'Class:OAuthClient/Attribute:client_secret' => '客户端密钥',
	'Class:OAuthClient/Attribute:client_secret+' => 'Another long string of characters provided by your OAuth2 provider~~',
	'Class:OAuthClient/Attribute:refresh_token' => 'Refresh Token',
	'Class:OAuthClient/Attribute:refresh_token+' => '',
	'Class:OAuthClient/Attribute:refresh_token_expiration' => 'Refresh Token 的有效期',
	'Class:OAuthClient/Attribute:refresh_token_expiration+' => '',
	'Class:OAuthClient/Attribute:token' => 'Access Token',
	'Class:OAuthClient/Attribute:token+' => '',
	'Class:OAuthClient/Attribute:token_expiration' => 'Access Token 的有效期',
	'Class:OAuthClient/Attribute:token_expiration+' => '',
	'Class:OAuthClient/Attribute:redirect_url' => '重定向 url',
	'Class:OAuthClient/Attribute:redirect_url+' => <<<EOF
此 URL 必须从服务商的 OAuth2 配置中复制
清空输入框以重新计算默认值
EOF
,
	'Class:OAuthClient/Attribute:mailbox_list' => '邮箱列表',
	'Class:OAuthClient/Attribute:mailbox_list+' => '',
]);

//
// Class: OAuthClientAzure
//

Dict::Add('ZH CN', 'Chinese', '简体中文', [
	'Class:OAuthClientAzure' => 'OAuth Mail Access for Microsoft Azure~~',
	'Class:OAuthClientAzure/Name' => '%1$s (%2$s)',
	'Class:OAuthClientAzure/Attribute:scope' => '使用范围',
	'Class:OAuthClientAzure/Attribute:scope+' => '通常情况下使用默认选择最合适',
	'Class:OAuthClientAzure/Attribute:scope/Value:SMTP' => 'SMTP',
	'Class:OAuthClientAzure/Attribute:scope/Value:SMTP+' => '',
	'Class:OAuthClientAzure/Attribute:scope/Value:IMAP' => 'IMAP',
	'Class:OAuthClientAzure/Attribute:scope/Value:IMAP+' => '',
	'Class:OAuthClientAzure/Attribute:advanced_scope' => '高级范围',
	'Class:OAuthClientAzure/Attribute:advanced_scope+' => '您在此输入的内容将优先于 "使用范围" 选择并导致其被忽略',
	'Class:OAuthClientAzure/Attribute:used_scope' => '使用范围',
	'Class:OAuthClientAzure/Attribute:used_scope+' => '',
	'Class:OAuthClientAzure/Attribute:used_scope/Value:simple' => '简单',
	'Class:OAuthClientAzure/Attribute:used_scope/Value:simple+' => '',
	'Class:OAuthClientAzure/Attribute:used_scope/Value:advanced' => '高级',
	'Class:OAuthClientAzure/Attribute:used_scope/Value:advanced+' => '',
	'Class:OAuthClientAzure/Attribute:used_for_smtp' => '用于SMTP',
	'Class:OAuthClientAzure/Attribute:used_for_smtp+' => '如果您需要使用 iTop 系统发送邮件, 则至少需要有一个 OAuth 客户端标记为 "是"',
	'Class:OAuthClientAzure/Attribute:used_for_smtp/Value:yes' => '是',
	'Class:OAuthClientAzure/Attribute:used_for_smtp/Value:no' => '否',
	'Class:OAuthClientAzure/Attribute:tenant' => '租户',
	'Class:OAuthClientAzure/Attribute:tenant+' => '配置给应用程序的租户ID. 对于多租户应用程序, 选择 "通用".',
]);

//
// Class: OAuthClientGoogle
//

Dict::Add('ZH CN', 'Chinese', '简体中文', [
	'Class:OAuthClientGoogle' => 'OAuth Mail Access for Google~~',
	'Class:OAuthClientGoogle/Name' => '%1$s (%2$s)',
	'Class:OAuthClientGoogle/Attribute:scope' => '使用范围',
	'Class:OAuthClientGoogle/Attribute:scope+' => '通常情况下使用默认选择最合适',
	'Class:OAuthClientGoogle/Attribute:scope/Value:SMTP' => 'SMTP',
	'Class:OAuthClientGoogle/Attribute:scope/Value:SMTP+' => '',
	'Class:OAuthClientGoogle/Attribute:scope/Value:IMAP' => 'IMAP',
	'Class:OAuthClientGoogle/Attribute:scope/Value:IMAP+' => '',
	'Class:OAuthClientGoogle/Attribute:advanced_scope' => '高级范围',
	'Class:OAuthClientGoogle/Attribute:advanced_scope+' => '您在此输入的内容将优先于 "使用范围" 选择并导致其被忽略',
	'Class:OAuthClientGoogle/Attribute:used_scope' => '使用范围',
	'Class:OAuthClientGoogle/Attribute:used_scope+' => '',
	'Class:OAuthClientGoogle/Attribute:used_scope/Value:simple' => '简单',
	'Class:OAuthClientGoogle/Attribute:used_scope/Value:simple+' => '',
	'Class:OAuthClientGoogle/Attribute:used_scope/Value:advanced' => '高级',
	'Class:OAuthClientGoogle/Attribute:used_scope/Value:advanced+' => '',
	'Class:OAuthClientGoogle/Attribute:used_for_smtp' => '用于SMTP',
	'Class:OAuthClientGoogle/Attribute:used_for_smtp+' => '如果您需要使用 iTop 系统发送邮件, 则至少需要有一个 OAuth 客户端标记为 "是"',
	'Class:OAuthClientGoogle/Attribute:used_for_smtp/Value:yes' => '是',
	'Class:OAuthClientGoogle/Attribute:used_for_smtp/Value:no' => '否',
]);
