<div id="cep-popup-check-cep-form" class="cep-popup-hidden">

    <h2>Checar seu CEP</h2>
    <p>Insira seu CEP para verificarmos se o seu endereço está na nossa área de cobertura!</p>

    <div id="cep-form-container">
        <div id="cep-form-container-states">
            <label for="cep-form-states">Seu estado:</label>
            <select name="cep-form-states" id="cep-form-states">
                <?php

                $default_country_code = CEP_Popup_Configs::DEFAULT_COUNTRY_CODE;
                $default_state_code = CEP_Popup_Configs::DEFAULT_STATE_CODE;

                $states_code = WC()->countries->states[$default_country_code];

                foreach ($states_code as $key => $value) {
                    $selected = $key === $default_state_code ? 'selected' : '';
                    $optionOutput = "<option value=$key $selected>$value</option>";
                    echo $optionOutput;
                }

                ?>
            </select>
        </div>

        <div id="cep-form-container-cep">
            <label for="cep-user">CEP</label>
            <?  // TODO: input inputmode="numeric" not supported by Firefox23+ Safari
            // CEP
            ?>
            <input type="number" name="cep-user" id="cep-form-usercep-input" placeholder="CEP" maxlength="8"></input>
        </div>

        <div id="cep-form-container-submit">
            <button id="cep-form-submit-cep-check-request" class="cep-popup-button">Avançar</button>
        </div>
    </div>

    <div id="buscaCEP">
        <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" rel=“nofollow” >Não sabe seu CEP?</a>
    </div>

</div>