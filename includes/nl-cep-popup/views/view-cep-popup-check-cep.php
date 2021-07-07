<div id="cep-form-group-states">
    <label for="cep-form-states">Select a country:</label>
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

<div id="cep-form-group-cep">
    <label for="cep-user">CEP</label>
    <?  // TODO: input inputmode="numeric" not supported by Firefox23+ Safari
    // CEP
    ?>
    <input type="input" inputmode="numeric" name="cep-user" id="cep-form-usercep-input" placeholder="CEP" required maxlength="8"></input>
</div>

<div id="cep-form-group-submit">
    <button id="cep-form-submit">Avançar</button>
</div>