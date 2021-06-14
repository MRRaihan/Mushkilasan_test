<!DOCTYPE html>
<html>
    <?php
    $query = $this->db->query("select * from system_settings WHERE status = 1");
    $result = $query->result_array();
    $this->website_name = '';
    $this->website_logo_front = 'assets/img/logo.png';
    $fav = base_url() . 'assets/img/favicon.png';
    if (!empty($result)) {
        foreach ($result as $data) {
            if ($data['key'] == 'website_name') {
                $this->website_name = $data['value'];
            }
            if ($data['key'] == 'favicon') {
                $favicon = $data['value'];
            }
            if ($data['key'] == 'logo_front') {
                $this->website_logo_front = $data['value'];
            }
            if($data['key'] == 'meta_title'){
				$this->meta_title =  $data['value'];
			}
			if($data['key'] == 'meta_description'){
				$this->meta_description =  $data['value'];
			}
			if($data['key'] == 'meta_keywords'){
				$this->meta_keywords =  $data['value'];
			}
        }
    }
    if (!empty($favicon)) {
        $fav = base_url() . 'uploads/logo/' . $favicon;
    }
    $lang = (!empty($this->session->userdata('lang'))) ? $this->session->userdata('lang') : 'en';


    $ColorList = $this->db->get('theme_color_change')->result_array();

    $Orgcolor = $ColorList[0]['status'];
    $Bluecolor = $ColorList[1]['status'];
    $Redcolor = $ColorList[2]['status'];
    $Greencolor = $ColorList[3]['status'];
    $Defcolor = $ColorList[4]['status'];
    ?>




    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo $this->meta_title;?></title>
        <meta name="viewport" content="<?php echo $this->meta_viewport; ?>">
        <meta name="description" content="<?php echo $this->meta_description; ?>">
        <meta name="keywords" content="<?php echo $this->meta_keywords; ?>">
		
		<meta name="robots" content="<?php echo $this->meta_robots; ?>" />
		<meta name="googlebot" content="<?php echo $this->meta_googlebot; ?>" />
		<meta http-equiv="content-language" content="<?php echo $this->meta_language; ?>">
		
		<META NAME="geo.position" CONTENT="<?php echo $this->meta_geo_position; ?>">
		<META NAME="geo.placename" CONTENT="<?php echo $this->meta_geo_placename; ?>">
		<META NAME="geo.region" CONTENT="<?php echo $this->meta_geo_region; ?>">
		
		<!--for fb-->
		<meta property="og:url" content="<?php echo $this->fb_og_url; ?>" />
		<meta property="og:type" content="<?php echo $this->fb_og_type; ?>" />
		<meta property="og:title" content="<?php echo $this->fb_og_title; ?>" />
		<meta property="og:description" content="<?php echo $this->fb_og_description; ?>" />
		<meta property="og:image" content="<?php echo $this->fb_og_img; ?>" />
		
		<!--for Google + -->
		<meta property="og:url" content="<?php echo $this->google_og_url; ?>" />
		<meta property="og:type" content="<?php echo $this->google_og_type; ?>" />
		<meta property="og:title" content="<?php echo $this->google_og_title; ?>" />
		<meta property="og:description" content="<?php echo $this->google_og_description; ?>" />
		<meta property="og:image" content="<?php echo $this->google_og_img; ?>" />
		
		<!--for Twitter -->
		<meta property="og:url" content="<?php echo $this->twitter_og_url; ?>" />
		<meta property="og:type" content="<?php echo $this->twitter_og_type; ?>" />
		<meta property="og:title" content="<?php echo $this->twitter_og_title; ?>" />
		<meta property="og:description" content="<?php echo $this->twitter_og_description; ?>" />
		<meta property="og:image" content="<?php echo $this->twitter_og_img; ?>" />





        <meta name="author" content="Dreamguy's Technologies">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $fav; ?>">

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/fontawesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/cropper.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/avatar.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/owlcarousel/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/owlcarousel/owl.theme.default.min.css">

        <!--Social Medica Icons styles in footer-->
        <style>
          .custom_nav_link {
              padding: .5rem 0rem;
          }
    
          /* Wrapper */
          .icon-button {
              background-color: #ededed;
              border-radius: 3rem;
              cursor: pointer;
              display: inline-block;
              font-size: 2.0rem;
              height: 3rem;
              line-height: 3.6rem;
              margin: 0 5px;
              position: relative;
              text-align: center;
              -webkit-user-select: none;
              -moz-user-select: none;
              -ms-user-select: none;
              user-select: none;
              width: 3rem;
          }
    
          /* Circle */
          .icon-button span {
              border-radius: 0;
              display: block;
              height: 0;
              left: 50%;
              margin: 0;
              position: absolute;
              top: 50%;
              -webkit-transition: all 0.3s;
              -moz-transition: all 0.3s;
              -o-transition: all 0.3s;
              transition: all 0.3s;
              width: 0;
          }
          .icon-button:hover span {
              width: 3rem;
              height: 3rem;
              border-radius: 3rem;
              margin: -1.5rem;
          }
          .twitter span {
              background-color: #4099ff;
          }
          .facebook span {
              background-color: #3B5998;
          }
          .google-plus span {
              /*background-color: #db5a3c;*/
              background-color: #E1306C;
          }
          .instagram span {
              background-color: #E1306C;
          }
    
          /* Icons */
          .icon-button i {
              background: none;
              color: white;
              height: 3rem;
              left: 0;
              line-height: 3rem;
              position: absolute;
              top: 0;
              -webkit-transition: all 0.3s;
              -moz-transition: all 0.3s;
              -o-transition: all 0.3s;
              transition: all 0.3s;
              width: 3rem;
              z-index: 10;
          }
          .icon-button .icon-twitter {
              color: #4099ff;
          }
          .icon-button .icon-facebook {
              color: #3B5998;
          }
          .icon-button .icon-google-plus {
              color: #db5a3c;
          }
          .icon-button .icon-instagram {
              color: #E1306C;
          }
          .icon-button:hover .icon-twitter,
          .icon-button:hover .icon-facebook,
          .icon-button:hover .icon-google-plus,
          .icon-button:hover .icon-instagram {
              color: white;
          }
        </style>
  
        <?php if ($module == 'home' || $module == 'services') { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css">
        <?php } ?>

        <?php if ($module == 'service') { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-select.min.css">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tagsinput.css">
        <?php } ?>    

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toaster/toastr.min.css">

        <?php if (!empty($Orgcolor) && $Orgcolor == 1) { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_org.css">
        <?php } else if (!empty($Bluecolor) && $Bluecolor == 1) { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_blue.css">
        <?php } else if (!empty($Redcolor) && $Redcolor == 1) { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_red.css">
        <?php } else if (!empty($Greencolor) && $Greencolor == 1) { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_green.css">
        <?php } else if (!empty($Defcolor) && $Defcolor == 1) { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
        <?php } ?>






        <?php if ($this->uri->segment(1) == "book-service") { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css">
        <?php } ?>
        
        <!--Google Maps API integration with css-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQpmYhb39ZGGUFb93nd2h9qfrruulxtmk&callback=initMap&libraries=&v=weekly" defer></script>
        <style type="text/css">
            /* Set the size of the div element that contains the map */
            #map {
              height: 110%;
              width: 200%;
            }
        </style>
        <script>
            // Initialize and add the map
            function initMap() {
              // The location of Uluru
              const uluru = { lat: 26.219645, lng: 50.523325 };//26.219645, 50.523325
              // The map, centered at Uluru
              const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 20,
                center: uluru,
              });
              // The marker, positioned at Uluru
              const marker = new google.maps.Marker({
                position: uluru,
                map: map,
              });
            }
        </script>

        <script src="<?php echo $base_url; ?>assets/js/jquery-3.5.0.min.js"></script>
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
    </head>



