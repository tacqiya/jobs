<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


$site_config = new stdClass();

# SITE SETTINGS ================================================================
# @ DELETE CONTROL show|hide
$site_config->delete_allowed = true;


$site_config->staff_1 = 'Aejaz Baig';
$site_config->staff_email_1 = 'ismail.baig@ku.ac.ae';
$site_config->staff_2 = 'Shaima Al Zaabi';
$site_config->staff_email_2 = 'shaima.alzaabi@ku.ac.ae';

$site_config->faculty_1 = 'Sali Iqeilan';
$site_config->faculty_email_1 = 'sali.Iqeilan@ku.ac.ae';
$site_config->faculty_2 = 'Gayathry Krishna';
$site_config->faculty_email_2 = 'gayathry.rajendran@ku.ac.ae';

$site_config->research_1 = 'Naila Mohamed';
$site_config->research_email_1 = 'naila.mohamed@ku.ac.ae';
$site_config->research_2 = 'Redyrick Reyes';
$site_config->research_email_2 = 'redyrick.reyes@ku.ac.ae';

$config['site_config'] = $site_config;