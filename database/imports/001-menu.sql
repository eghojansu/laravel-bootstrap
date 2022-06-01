-- Db root
INSERT INTO `csmenu` (`grp`, `parent`, `menuid`, `label`, `icon`, `route`, `attrs`, `grade`) VALUES
('db', null, 'db', 'Dashboard', 'house', 'dashboard', null, 1),
('db', null, 'ad', 'Administration', 'gear', null, null, 2);

INSERT INTO `csmenu` (`grp`, `parent`, `menuid`, `label`, `icon`, `route`, `perm`, `grade`) VALUES
('db', 'ad', 'aduser', 'Users', 'people', 'user.index', 'adm.user', 1),
('db', 'ad', 'adpref', 'Preference', 'bookmark-heart', 'preference', 'adm.pref', 2);

-- Ac root
INSERT INTO `csmenu` (`grp`, `parent`, `menuid`, `label`, `icon`, `route`, `attrs`, `grade`) VALUES
('ac', null, 'ac', 'Account', 'person-circle', null, null, 1);

INSERT INTO `csmenu` (`grp`, `parent`, `menuid`, `label`, `icon`, `route`, `attrs`, `grade`) VALUES
('ac', 'ac', 'acprof', 'Profile', 'person', 'profile', null, 1),
('ac', 'ac', 'acpass', 'Password', 'key', 'password', null, 2),
('ac', 'ac', 'acsep1', '--sep', null, null, null, 3),
('ac', 'ac', 'acout', 'Logout', 'box-arrow-right', 'logout', '{"data-confirm":"post","class":"text-danger"}', 4);
