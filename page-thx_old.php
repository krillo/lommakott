<?php
/*
  Template Name: Tack-sida
 */
get_header();
?>





<?php if (have_posts ()) : ?>
<?php while (have_posts ()) : the_post(); ?>
<?
    $to = isset($_POST['to']) ? $_POST["to"] : "";
    $from = isset($_POST['myname']) ? $_POST["myname"] : "";
    $message = isset($_POST['message']) ? $_POST["message"] : "";
    $casino = isset($_POST['casino']) ? $_POST["casino"] : "";
    $phone = isset($_POST['phone']) ? $_POST["phone"] : "";

    $content_to_show = "Mailet kunde tyvärr inte skickas. Försök igen senare eller kontakta oss gällande felet.";

    if ($to != "" && $message != "") {
      $headers = 'To: ' . $to . ' <' . $to . '>' . "\r\n";
      $headers .= 'From: ' . $to . ' <' . $to . '>' . "\r\n";
      $headers .= 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=UTF-8' . '\r\n';

      if (empty($casino)) {  //Tipsmailet
        $success = mail($to, "Tips från: " . $from, $message, $headers);
        if ($success):
          $content_to_show = get_the_content($post->ID);
        else:
          $content_to_show = "Mailet kunde tyvärr inte skickas. Försök igen senare eller kontakta oss gällande felet.";
        endif;
      } else {  // Casinomail
        $f = $casino. ": ". $from;
        $m = $message . "<br/><br/>" . $from ." " . $phone;
        $success = mail($to, $f, $m, $headers);
        if ($success):
          $content_to_show = get_the_content($post->ID);
        else:
          $content_to_show = "Mailet kunde tyvärr inte skickas. Försök igen senare eller kontakta oss gällande felet.";
        endif;
      }
    }
?>    
    <div class="breadcrumb">
<?php if (function_exists('dimox_breadcrumbs'))
      dimox_breadcrumbs(); ?>
    </div>

<?php include_once("sidebar-leftmenu.php"); ?>

  <div class="mainCol">

    <h1><?php the_title(); ?></h1>

      <div class="articleCol">
        <div class="article">
<?php echo $content_to_show ?>
        </div>
      </div>

<?php get_sidebar(); ?>

</div>

<?php endwhile; ?>

<?php else : ?>
      <h2 class="center">Sidan kunde inte hittas.</h2>
<?php endif; ?>        
<?php get_footer(); ?>