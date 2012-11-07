CREATE TABLE IF NOT EXISTS `#__worker_role` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `#__workers` (
  `id` int(11) NOT NULL auto_increment,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `s_n` varchar(255) NOT NULL,
  `dob` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `dl_no` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cell` varchar(255) NOT NULL,
  `home` varchar(255) NOT NULL,
  `shirt_size` varchar(255) NOT NULL,
  `pant_leg` varchar(255) NOT NULL,
  `waist` varchar(255) NOT NULL,
  `receive_update_by` varchar(255) NOT NULL,
  `desired_shift` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `active_status` int(11) NOT NULL,
  `verified_status` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

