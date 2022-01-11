<div class="page-container">

  <div class="form-container">

    <div class="form-group">

      <div class="form-items">

        <div class="form-title">
          <div class="center">
            <h1>Skapa konto</h1>

            <div class="title-description">Fortsätt till
              <a href="<?= $GLOBALS["basePath"] ?>">Noisy</a>
            </div>



          </div>
        </div>

        <!-- Posting to /signup, check post route in index.php -->
        <form id="formRef" method="post" action="<?= "$this->base_path/signup" ?>">

          <div class="form-item">
            <input type="text" id="username" name="username" autocomplete="off" placeholder="Användarnamn" autofocus>
            <span id="status"></span>
          </div>

          <div class="form-item">
            <input type="password" id="password" name="password" placeholder="Lösenord">
          </div>

          <div class="form-options">
            <div class="options-container">
              <!-- Redirects to route /signin -->
              <a href="<?= "$this->base_path/signin" ?>">Logga in</a>
              <button class="btn" name="submit" value="signup" type="submit">Skicka</button>
            </div>
          </div>

        </form>

      </div>

    </div>

  </div>

</div>

<script type="module" src="<?= $GLOBALS["baseUrl"] . $GLOBALS["basePath"] . '/public/js/validate.js' ?>"></script>