<?php include './views/home_page/layout_header.php'; ?>
<?php include './views/home_page/layout_nav.php'; ?>

<link rel="stylesheet" href="/assets/css/Contact.css"/>

    <!--========== HERO START ==========-->
    <section class="hero-section">
      <img
        src="/assets/image/Kasir Modern.jpg"
        class="hero-img"
        alt="Boots - Autumn Collection"
      />
      <div class="cta">
        <div class="cta-text">
          <h1>KONTAK</h1>
        </div>
      </div>
      <div class="cta-clip">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis autem minima porro numquam. Incidunt, expedita amet aut illum iure debitis temporibus possimus. Suscipit quo maxime cumque ad! Obcaecati officiis sit atque delectus asperiores laboriosam magni, molestiae ipsum, quod sequi distinctio.</p>
      </div>
    </section>
    <!--========== HERO END ==========-->
    <!--========== CONTENT START ==========-->
    <div class="content">
      <div class="peta">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.1797750485835!2d106.8210956754032!3d-6.37077619361941!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ec1cabb59bdf%3A0x28b4f84e4677f329!2sPoliteknik%20Negeri%20Jakarta!5e0!3m2!1sid!2sid!4v1689349573605!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
      <div class="mail">
        <h1>Hubungi Kami</h1>
        <form method="post" action="#" enctype="multipart/form-data" class="form">
          <input type="email" id="email" name="email" placeholder="Email" class="data" required><br><br>         
          <input type="text" id="subjek" name="subjek" placeholder="Subjek" class="data" required><br><br>
          <textarea id="isi" name="isi" rows="4" cols="50" class="isi" required></textarea><br><br>
          <input type="file" id="file" name="file" class="data"><br><br>
          <input type="submit" value="Kirim" class="btn">
        </form>
      </div>
    </div>
    <!--========== CONTENT END ==========-->

<?php include './views/home_page/layout_footer.php'; ?>
