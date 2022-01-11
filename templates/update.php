<div class="navbar">
  <div class="nav-items">

    <div class="logo">
      <span><a href="<?= $this->base_path ?>">Noisy.</a></span>
    </div>

    <div class="nav-options">

      <div class="nav-option">
        <div>
          <a href="<?= "$this->base_path/$this->is_logged" ?>" class="opt-path">Min blogg</a>
        </div>
      </div>

      <a href="<?= "$this->base_path/signout" ?>" class="btn">Logga ut</a>

    </div>
  </div>
</div>

<?php if ($this->blog == $this->is_logged) : ?>

  <div class="page-container">

    <div class="content-container">

      <div class="form-group">

        <div class="form-items">

          <form class="editor-mode" method="post" action="<?= "$this->base_path/update" ?>">

            <input type="text" class="create-title" value="<?= $this->post['title'] ?>" name="title" readonly>
            <input type="hidden" name="id" value="<?= $this->post['id'] ?>">
            <input type="hidden" name="author" value="<?= $this->post['author'] ?>">

            <textarea name="content" id="editor">
                        <?= str_replace('&', '&amp;', $this->post['content']) ?>
                    </textarea>

            <div class="form-options">
              <div class="options-container">
                <a></a>
                <button class="btn" name="submit" value="submit" type="submit">Uppdatera</button>
              </div>
            </div>
          </form>

        </div>

      </div>

    </div>

  </div>

  <script type="module" src="<?= "$this->base_url$this->base_path/public/js/editor.js" ?>"></script>

<?php else : ?>

  <div class="wrapper">

    <section class="no-sidebar">

      <p>Du har inte befogenhet att göra några ändringar i detta inlägg.</p>

    </section>

  </div>

<?php endif; ?>