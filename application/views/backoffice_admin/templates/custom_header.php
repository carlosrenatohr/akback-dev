<!DOCTYPE html>
<html ng-app="akamaiposApp" lang="en">
<head>
    <meta charset="utf-8" />
</head>
<title>AK <?php echo (isset($page_title)) ? $page_title: ''?></title>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.10.2.min.js")?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/custom.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrapValidator.js')?>"></script>
<?php hdplugins()?>
<link href="<?php echo base_url('assets/css/global.css')?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('assets/css/font-awesome.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/custom.css')?>" rel="stylesheet">
<style type="text/css">
    body{
        color: #000;
    }
</style>
<body ng-cloak>
