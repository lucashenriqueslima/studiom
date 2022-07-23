
    <div class="pac-card" id="pac-card">
      <div>
        <div id="title">Pesquisar local</div>
        
          <input
            type="radio"
            name="type"
            id="changetype-all"
            checked="checked"
          />
          <label for="changetype-all">Todos</label>

          <input type="radio" name="type" id="changetype-establishment" />
          <label for="changetype-establishment">estabelecimento</label>

          <input type="radio" name="type" id="changetype-address" />
          <label for="changetype-address">endereço</label>

          <input type="radio" name="type" id="changetype-geocode" />
          <label for="changetype-geocode">geocode</label>

          <input type="radio" name="type" id="changetype-cities" />
          <label for="changetype-cities">(cidades)</label>

          <input type="radio" name="type" id="changetype-regions" />
          <label for="changetype-regions">(região)</label>
        
        <br />
        
        <div id="strict-bounds-selector" class="pac-controls">
          <input type="checkbox" id="use-location-bias" value="" checked />
          <label for="use-location-bias">Polarização para mapear janela de visualização</label>

          <input type="checkbox" id="use-strict-bounds" value="" />
          <label for="use-strict-bounds">Limites estritos</label>
        </div>

      </div>
      <div id="pac-container">
        <input class="form-control border border-primary" id="pac-input" type="text" placeholder="Insira o local" style="margin-top: 1em; margin-bottom: 1em; " />
      </div>
    </div>
    <div class="modal-body" id="map" style="width:100%; height: 600px"></div>
    <div id="infowindow-content" style="position: relative;">
      <span id="place-name" class="title"></span><br />
      <span id="place-address"></span>
    </div>
