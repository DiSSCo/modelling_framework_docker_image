<?php
#Set logo and icon
$wgLogo = "/w/images/dissco_modelling_framework_logo_transparent.png";
$wgFavicon = "/w/images/dissco_modelling_framework_favicon.ico";

#allowing users to change the styling and functionality for them
$wgAllowUserCss = true;
$wgAllowUserJs = true;


#####
#
# Access Rights
#
#####

# Allow reading by anonymous users
$wgGroupPermissions['*']['read'] = true;

# Disable anonymous editing
$wgGroupPermissions['*']['edit'] = false;
 
# Prevent new user registrations except by sysops
$wgGroupPermissions['*']['createaccount'] = false;

# Disable editting and reading for retired users
# (overwrites settings by $wgGroupPermissions)
$wgRevokePermissions['retiredUser']['read'] = true;
$wgRevokePermissions['retiredUser']['edit'] = false;

# Grant rights for active users
$wgGroupPermissions['activeUser']['read'] = true;
$wgGroupPermissions['activeUser']['edit'] = true;
$wgGroupPermissions['activeUser']['delete'] = true;

# set rights for readingOnlyUser
$wgGroupPermissions['readingOnlyUser']['read'] = true;
# (overwrites settings by $wgGroupPermissions)
$wgRevokePermissions['readingOnlyUser']['edit'] = false;

# user is NOT retired, NOR readingOnly? --> make it active
$wgAutopromote['activeUser'] = array('!',
	array('|',
		array(APCOND_INGROUPS, 'retiredUser'),
		array(APCOND_INGROUPS, 'readingOnlyUser')));

# retiredUser should be able to logout
$wgWhitelistRead[] = "Special:UserLogout";

# additional OAuth permissions
$wgGroupPermissions['sysop']['mwoauthsuppress'] = true;
$wgGroupPermissions['sysop']['mwoauthviewsuppressed'] = true;
$wgGroupPermissions['sysop']['mwoauthmanagemygrants'] = true;


######
#
# Wikibase Specific Settings
#
######

// remove the siteLinkGroups, was previously blocks like: wikipedia, wikinews, special, etc
$wgWBRepoSettings['siteLinkGroups'] = [];

//Property for the formatter URL for external Identifier
$wgWBRepoSettings['formatterUrlProperty'] = 'P3';

// set user rights: editing of entities by default is off, 
// while a logged in user can edit everything. 
// First block sets all rights for anonymous to false, that is they have no rights.
$wgGroupPermissions['*']['item-term'] = false;
$wgGroupPermissions['*']['item-merge'] = false;
$wgGroupPermissions['*']['property-term'] = false;
$wgGroupPermissions['*']['property-create'] = false;
// Second block sets all rights for users to true, that is they hold the rights.
$wgGroupPermissions['user']['item-term'] = true;
$wgGroupPermissions['user']['item-merge'] = true;
$wgGroupPermissions['user']['property-term'] = true;
$wgGroupPermissions['user']['property-create'] = true;

//add "Query" and "Query talk" namespaces
$baseNs = 120;
define( 'WB_NS_QUERY', $baseNs +4 );
define( 'WB_NS_QUERY_TALK', $baseNs +5 );
$wgExtraNamespaces[WB_NS_QUERY] = 'Query';
$wgExtraNamespaces[WB_NS_QUERY_TALK] = 'Query_talk';