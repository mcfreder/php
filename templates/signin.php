<div class="page-container">
  <div class="form-container">
    <div class="form-group">
      <div class="form-items">

        <div class="form-title">
          <div class="center">
            <h1>Logga in</h1>

            <div class="title-description">Fortsätt till
              <a href="<?= $this->base_path ?>">Noisy</a>
            </div>

          </div>
        </div>

        <!-- Posting to /login, check post route in index.php -->
        <form id="formRef" action="<?= "$this->base_path/signin" ?>" method="post">

          <div class="form-item">
            <input type="text" id="username" name="username" autocomplete="off" placeholder="Användarnamn" autofocus>
            <span id="status"></span>
          </div>

          <div class="form-item">
            <input type="password" id="password" name="password" placeholder="Lösenord">
          </div>

          <div class="form-options">
            <div class="options-container">
              <!-- Redirects to route /signup -->
              <a href="<?= "$this->base_path/signup" ?>">Skapa konto</a>
              <button class="btn" name="submit" value="login" type="submit">Logga in</button>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

<script type="module" src="<?= "$this->base_url$this->base_path/public/js/validate.js" ?>"></script>