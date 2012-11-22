<?php
/*
  Template Name: Tack
 */

$order = new stdClass;
!empty($_REQUEST['email']) ? $order->email = $_REQUEST['email'] : $order->email = '';
!empty($_REQUEST['firstname']) ? $order->fname = $_REQUEST['firstname'] : $order->fname = '';
!empty($_REQUEST['lastname']) ? $order->lname = $_REQUEST['lastname'] : $order->lname = '';
!empty($_REQUEST['phone']) ? $order->phone = $_REQUEST['phone'] : $order->phone = '';
!empty($_REQUEST['street1']) ? $order->street = $_REQUEST['street1'] : $order->street = '';
!empty($_REQUEST['street2']) ? $order->street = $order->street . ' ;; ' . $_REQUEST['street2'] : null;
!empty($_REQUEST['zip']) ? $order->zip = $_REQUEST['zip'] : $order->zip = '';
!empty($_REQUEST['city']) ? $order->city = $_REQUEST['city'] : $order->city = '';

$article = array();
foreach ($_POST as $key => $amount) {
  if (strpos($key, 'count') !== false) {
    if ($amount != 0) {
      $ID = substr($key, 6);
      $name = get_field('name', $ID);
      $price = get_field('price', $ID);
      $sum = $price * $amount;
      $order->total += $sum;
      $article[$name] = array($amount . " st", $price . " kr/st", $sum . " kr");
    }
  }
}
$article_json = json_encode($article);

global $wpdb;
$table_name = $wpdb->prefix . 'order';
$sql = "INSERT INTO " . $table_name . " (fname, lname, address, zip, city, phone, email, orders, sum) VALUES ('" . $order->fname . "', '" . $order->lname . "', '" . $order->street . "', '" . $order->zip . "', '" . $order->city . "', '" . $order->phone . "', '" . $order->email . "', '" . $article_json . "', '" . $order->total . "');";
$wpdb->get_results($sql);
$orderid = $wpdb->insert_id;


//send mail
$to = "krillo@gmail.com";
$from = "order@lommakkott.se";

$message = "Order nr: $orderid<br/>";
$message .= date("Y-m-d H:i:s") . "<br/><br/>";
foreach ($article as $key => $value) {
  $message .= $value[0] . " " . $value[1] . " " . $value[2] . " " . $key . "<br/>";
  ;
}
$message .= "--------------------<br/>";
$message .= "Totalt: " . $order->total . " kr <br/><br/>";

$message .= "$order->fname  $order->lname <br/>";
$message .= "$order->street<br/>";
$message .= "$order->zip  $order->city <br/><br/>";
$message .= "Telefon: $order->phone<br/>";
$message .= "Email: $order->email<br/>";


$headers = 'To: ' . $to . ' <' . $to . '>' . "\r\n";
$headers .= 'From: ' . $from . ' <' . $from . '>' . "\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . '\r\n';


$success = mail($to, "Order nr: $orderid", $message, $headers);
if (!$success) {
  
}
?>

<?php get_header(); ?>



<div id="primary">
  <div id="content" role="main">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h1 class="entry-title"><?php the_title(); ?></h1>        
        <?php the_content(); ?>  
        <div id="kvitto">
          <h2>Din order</h2>
          <?php echo $message; ?>
        </div>
          <?php
        endwhile;
      endif;
      ?>


  </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>




<!--
MySqlCommand cmd = new MySqlCommand("insert into tableA values(0,'myname')",conn) 
cmd.ExecNonQuery(); 

myID = cmd.LastInsertId; 

-->