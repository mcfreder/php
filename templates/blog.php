<div class="navbar">
  <div class="nav-items">
    <div class="logo">
      <span><a href="<?= $this->base_path ?>">Noisy.</a></span>
    </div>
    <div class="nav-options">

      <?php if ($this->is_logged) : ?>

        <div class="nav-option">
          <div>

            <?php if ($this->blog == $this->is_logged) : ?>

              <a href="<?= "$this->base_path/create" ?>">Nytt inlägg</a>

            <?php else : ?>

              <a href="<?= "$this->base_path/$this->is_logged" ?>">Min blogg</a>

            <?php endif; ?>

          </div>

        </div>

        <a href="<?= "$this->base_path/signout" ?>" class="btn">Logga ut</a>

      <?php else : ?>

        <a href="<?= "$this->base_path/signin" ?>" class="btn">Logga in</a>

      <?php endif; ?>

    </div>
  </div>
</div>

<div class="wrapper">

  <?php if ($this->post) : ?>

    <header>
      <h1>Alla inlägg
        <span class="small-txt">• <?= count($this->data) ?></span>
      </h1>

      <?php foreach ($this->data as $key => $value) : ?>

        <p class="post-link">
          <a class="
                    <?php if ($this->data[$key]['slug'] == $this->post['slug']) {
                      echo "active";
                    } else {
                      echo "noactive";
                    } ?>" href="<?= "$this->base_path/{$this->data[$key]['author']}/{$this->data[$key]['slug']}" ?>">
            <?= $this->data[$key]['title'] ?>
          </a>
        </p>

      <?php endforeach; ?>

    </header>

    <section>
      <div class="posted">
        <h1><?= $this->date(); ?></h1>
        <div>av <?= $this->post['author'] ?>
          <?php if ($this->blog == $this->is_logged) : ?>
            •
            <a href="<?= "$this->base_path/{$this->post['author']}/{$this->post['slug']}/edit" ?>">redigera</a> •
            <a href="<?= "$this->base_path/{$this->post['author']}/{$this->post['slug']}/delete" ?>">ta bort</a>
          <?php endif; ?>
        </div>
      </div>

      <h1>
        <?= $this->post['title'] ?>
      </h1>

      <div class="content">
        <?= $this->post['content'] ?>
      </div>

    </section>

    <footer>
      <p>
        <small>© All rights reserved.<br> @ <a href="<?= $this->base_path ?>">Marcus Eriksson</a></small>
      </p>
    </footer>

  <?php else : ?>

    <!-- Load admin tool if user is auth. -->
    <?php if ($this->blog == $this->is_logged) : ?>

      <section class="no-sidebar">
        <p>
          Ops! Här var det tomt!
          <a href="<?= "$this->base_path/create" ?>">Skapa</a> ett inlägg nu!
        </p>
      </section>

    <?php else : ?>

      <section class="no-sidebar">
        <p>Användaren finns inte eller har ännu inte skapat något inlägg.</p>
      </section>

    <?php endif; ?>

  <?php endif; ?>

</div>