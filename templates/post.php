<div class="navbar">
  <div class="nav-items">

    <div class="logo">
      <span><a href="<?= $this->base_path ?>">Noisy.</a></span>
    </div>

    <div class="nav-options">

      <div class="nav-option">
        <div>
          <a href="<?= $this->is_logged ?>">Min blogg</a>
        </div>
      </div>

      <a href="<?= "$this->base_path/signout" ?>" class="btn">Logga ut</a>

    </div>
  </div>
</div>

<div class="page-container">

  <div class="content-container">

    <div class="form-group">

      <div class="form-items">

        <form class="editor-mode" action="<?= "$this->base_path/create" ?>" method="post">
          <input type="text" class="create-title" placeholder="Lägg till en titel" name="title" required autocomplete="off">

          <textarea name="content" id="editor">
                        &lt;p&gt;Redigera ditt innehåll här.&lt;/p&gt;
                    </textarea>

          <!-- Options -->
          <div class="form-options">
            <div class="options-container">
              <a></a>
              <button class="btn" name="submit" value="login" type="submit">Publicera</button>
            </div>
          </div>
        </form>

      </div>

    </div>

  </div>

</div>


<script type="module" src="<?= "$this->base_url$this->base_path/public/js/editor.js" ?>"></script>