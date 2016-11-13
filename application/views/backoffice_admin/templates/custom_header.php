<!DOCTYPE html>
<html ng-app="akamaiposApp" lang="en">
<head>
    <title>AK <?php echo (isset($page_title)) ? $page_title: ''?></title>
    <meta charset="utf-8" />
</head>
<!--<script type="text/javascript" src="--><?php //echo base_url("assets/js/jquery-1.10.2.min.js")?><!--"></script>-->
<!--<script src="--><?php //echo base_url('assets/js/bootstrap.min.js') ?><!--"></script>-->
<!--<script src="--><?php //echo base_url('assets/js/custom.js') ?><!--"></script>-->
<!--<script src="--><?php //echo base_url('assets/js/bootstrapValidator.js')?><!--"></script>-->
<?php //hdplugins()?>
<!--<link href="--><?php //echo base_url('assets/css/global.css')?><!--" rel="stylesheet" type="text/css">-->
<!--<link href="--><?php //echo base_url('assets/css/font-awesome.css')?><!--" rel="stylesheet">-->
<!--<link href="--><?php //echo base_url('assets/css/custom.css')?><!--" rel="stylesheet">-->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.12.0.min.js"></script>
<?php if (!isset($load_libs)) { ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/dist/jqxangular.min.js"></script>
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/admin/dist/jqxstyles.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/js/angular/jqwidgets/styles/jqxthemes.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/admin/styles.css">
<script type="text/javascript">
    var SiteRoot ="<?php echo base_url() ?>";
</script>

<body ng-cloak>
