<?php if (!isset($title)) {$title = "SBWMS";} ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Service Booking and Workshop Management System">
    <meta name="author" content="Vinura">
    <link rel="icon" href="">

    <title><?= $title; ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= url_for('/assets/css/bootstrap_modified.css'); ?>">
   
    <!-- Custom styles -->
    <link rel="stylesheet" href="<?= url_for('/assets/css/custom/stylesheet.css'); ?>">
    <link rel="stylesheet" href="<?= url_for('/assets/css/plugins/jquery.mCustomScrollbar.css'); ?>">
    <link rel="stylesheet" href="<?= url_for('/assets/css/custom/cardstyles.css'); ?>">
    <link rel="stylesheet" href="<?= url_for('/assets/css/custom/tablestyles.css'); ?>">

    <!-- Icon styles -->
    <link rel="stylesheet" href="<?= url_for('/assets/fonts/fontawesome/css/all.css'); ?>">
    <link rel="stylesheet" href="<?= url_for('/assets/fonts/font/flaticon.css'); ?>">

    <!-- Base Font -->
    <link rel="stylesheet" href="<?= url_for('/assets/css/custom/fontstyles.css') ?>">

    <!-- Animate.css -->
    <link rel="stylesheet" href="<?= url_for('/assets/css/animate.css'); ?>">

    <!-- DataTables css -->
    <link rel="stylesheet" href="<?= url_for('/assets/css/plugins/DataTables/dataTables.bootstrap4.css'); ?>"/>
    <link rel="stylesheet" href="<?= url_for('/assets/css/plugins/DataTables/buttons.bootstrap4.css'); ?>"/>
    <!-- <link rel="stylesheet" href="<?= url_for('assets/css/plugins/bootstrap-combobox.css'); ?>"/> -->
    <!-- <link rel="stylesheet" href="<?= url_for('assets/css/plugins/select2-bootstrap4.css'); ?>"/> -->
    <link rel="stylesheet" href="<?= url_for('assets/css/plugins/chosen.css'); ?>"/>
    <link rel="stylesheet" href="<?= url_for('assets/css/plugins/jquery.timepicker.min.css'); ?>"/>
    <link rel="stylesheet" href="<?= url_for('assets/css/plugins/bootstrap-datepicker3.min.css'); ?>"/>
  </head>
