<?php
/*
  Template Name: Lommakött
 */
get_header();
?>
<style>
  .the-sum{border-top:solid 1px #000;}
  .invalid {border-color: red;}
</style>

<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
<script type="text/javascript">    
  jQuery(function($) {
    
    
 /******************************
  * Events
  ******************************/  
    $('.count').change(function() {
    var self = jQuery(this);
    count = self.val();
    id = self.attr('id');
    price = $('#price-'+id).html();
    $('#sum-'+id).html(price*count*0.1);
      
      
      
    //sumShort = parseInt(shortRadio) + parseInt(shortCheck);  
    var total = 0;
    $(".article-sum").each(function (i) {
      article_sum = parseInt(this.innerHTML);
      total += article_sum;
      });
    $('#total-sum').html(total);  
      
    });






    var validator = $("#buy").validate({
      errorClass: "invalid",
      validClass: "valid",
      messages: {
        "firstname": {
          required: 'Saknas'
        },
        "lastname": {
          required: 'Saknas'
        },
        "street1": {
          required: 'Saknas'
        },
        "zip": {
          required: 'Saknas'
        },
        "city": {
          required: 'Saknas'
        },
        "phone": {
          required: 'Saknas'
        },
        "email": {
          required: 'Saknas', 
          email: 'Felaktig'
        }
      }
    });









  });
</script>



<div id="primary">
  <div id="content" role="main">
        <form id="buy" action="/kvitto" method="post">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h1 class="entry-title"><?php the_title(); ?></h1>      
        <?php  the_content(); ?>   
      <?php endwhile;
    endif; ?>
    <table border="1" id="product-table">
      <thead>
        <tr>
          <th>Hekto</th>
          <th>Summa</th>
          <th>Produkt</th>
          <th>Pris per kilo</th>
        </tr>
      </thead>
      <tbody>
        <?php
        query_posts(array('post_type' => 'produkt', 'orderby' => 'date', 'order' => 'DESC',));
        if (have_posts()) : while (have_posts()) : the_post(); 
          $show = get_field('available');
          if($show == "Ja"){
            ?>
            <tr>
              <td><select name="count-<?php the_ID(); ?>" id="<?php the_ID(); ?>" class="count">
                  <option>0</option>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                  <option>6</option>
                  <option>7</option>
                  <option>8</option>
                  <option>9</option>
                  <option>10</option>
                  <option>12</option>
                  <option>13</option>
                  <option>20</option>
                  <option>30</option>
                  <option>40</option>
                  <option>50</option>
                  <option>60</option>
                  <option>70</option>
                  <option>80</option>
                  <option>90</option>
                  <option>100</option>
                </select></td>
              <td id="sum-<?php the_ID(); ?>" class="article-sum">0</td>
              <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
              <td>(<span id="price-<?php the_ID(); ?>"><?php the_field('price'); ?></span> kr)</td>
            </tr>
            <?php
          }
          endwhile;
        endif;
        ?>
          <tr>
            <td class="the-sum"></td>
            <td class="the-sum" id="total-sum">0 kr</td>
            <td></td>
            <td></td>
          </tr>
      </tbody>
    </table>


        <ul class="buy-ul" id="address">
          <li><div >Förnamn* </div><input type="text" name="firstname" id="firstname" class="required" /></li>
          <li><div >Efternamn* </div><input type="text" name="lastname" id="lastname" class="required" /></li>
          <li><div >Mobil/telefon* </div><input type="text" name="phone" id="phone"  class="required"/></li>
          <li><div >Gata* </div><input type="text" name="street1" id="street1" class="required"/></li>
          <li><div >&nbsp;</div><input type="text" name="street2" id="street2" /></li>
          <li><div >Postnummer* </div><input type="text" name="zip" id="zip" class="required"/></li>
          <li><div >Stad* </div><input type="text" name="city" id="city" class="required" /></li>
          <li><div >E-post* </div><input type="text" name="email" id="email" class="required email" /></li>
          <li><div >&nbsp; </div><input type="submit" name="" id="skicka" class="" value="Skicka beställning"/></li>
        </ul>
      </div>        
        </form>


  </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>