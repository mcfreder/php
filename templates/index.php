<div class="navbar">
  <div class="nav-items">

    <div class="logo">
      <span><a href="<?= $this->base_path ?>">Noisy.</a></span>
    </div>

    <div class="nav-options">

      <?php if ($this->is_logged) : ?>

        <div class="nav-option">
          <div>
            <a href="<?= $this->is_logged ?>">Min blogg</a>
          </div>
        </div>

        <a href="<?= "$this->base_path/signout" ?>" class="btn">Logga ut</a>

      <?php else : ?>

        <a href="<?= "$this->base_path/signin" ?>" class="btn">Logga in</a>

      <?php endif; ?>

    </div>
  </div>
</div>

<!-- Bara detta kvar att fixa! -->

<div class="_wrapper">

  <div class="news-container">

    <div class="news-items">

      <h1>Nyheter</h1>

      <?php if ($this->posts) : ?>

        <div class="container">

          <?php foreach ($this->posts as $key => $value) : ?>

            <div class="item">

              <h1><?= $this->posts[$key]['title'] ?></h1>

              <p><?= $this->read_more($this->posts[$key]['content']); ?></p>

              <div class="right">
                <a class="btn" href="<?= "$this->base_path/{$this->posts[$key]['author']}/{$this->posts[$key]['slug']}" ?>">Läs mer</a>
              </div>

            </div>

          <?php endforeach; ?>

        </div>

      <?php endif; ?>

      <h1>Bloggare</h1>

      <?php if ($this->data) : ?>

        <div class="grid-container">

          <?php foreach ($this->data as $key => $value) : ?>

            <a class="grid-item" href="<?= $this->data[$key]['username'] ?>">
              <?= $this->data[$key]['username'] ?>
            </a>

          <?php endforeach; ?>

        </div>

      <?php endif; ?>

      <div class="footer">
        <div>Copyright © 2021 Noisy.</div>
      </div>

    </div>

  </div>

</div>