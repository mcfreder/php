<div class="navbar">
  <div class="nav-items">

    <div class="logo">
      <span><a href="<?= $this->base_path ?>">Noisy.</a></span>
    </div>

    <div class="nav-options">

      <div class="nav-option">
        <div>
          <a href="<?= "$this->base_path/$this->is_logged" ?>">Min blogg</a>
        </div>
      </div>

      <a href="<?= "$this->base_path/signout" ?>" class="btn">Logga ut</a>

    </div>
  </div>
</div>

<div class="wrapper">

  <?php if ($this->blog == $this->is_logged) : ?>

    <section class="no-sidebar">

      <form method="post" action="<?= "$this->base_path/delete" ?>">
        <p>Är du säker på att du vill ta bort <a href="<?= "$this->base_path/$this->blog/{$this->post['slug']}" ?>"><?= $this->post['title'] ?></a>?</p>

        <input type="hidden" name="author" value="<?= $this->post['author'] ?>">
        <input type="hidden" name="id" value="<?= $this->post['id'] ?>">

        <button class="btn" name="submit" value="submit" type="submit">Ja</button>

      </form>

    </section>


  <?php else : ?>

    <section class="no-sidebar">

      <p>Du har inte befogenhet att göra några ändringar i detta inlägg.</p>

    </section>

  <?php endif; ?>

</div>