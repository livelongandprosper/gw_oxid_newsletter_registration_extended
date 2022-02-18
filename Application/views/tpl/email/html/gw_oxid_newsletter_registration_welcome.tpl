[{assign var="shop"      value=$oEmailView->getShop()}]
[{assign var="oViewConf" value=$oEmailView->getViewConfig()}]
[{assign var="user"      value=$oEmailView->getUser()}]

[{include file="email/html/header.tpl" title="GW_NEWSLETTER_REGISTRATION_WELCOME"|oxmultilangassign}]

[{oxcontent ident="gw_nl_welcome_text_html"}]

[{include file="email/html/footer.tpl"}]
