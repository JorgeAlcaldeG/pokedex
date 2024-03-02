<div class="modal fade" id="configModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="confTitulo">Configuración</h1>
            <button type="button" class="btn-close" id="cerrarBtn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <label class="optConf" for="column-list">Cuadriculas por fila</label>
            <select name="column-list" id="column-list">
                <option name="4" id="4">4</option>
                <option name="5" id="5">5</option>
                <option name="6" id="6">6</option>
            </select>
            <br>
            <label class="optConf" for="frames">Recuadros</label>
            <div class="fila">
                <div class="column2">
                    <label style="margin:3%">
                        <input type="radio" name="frames" value="1" id="frame1" class="framechk">
                        <img class="frameconfimg" src="./resources/interfaz/Marco1.png" alt="Option 1">
                    </label>
                </div>
                <div class="column2">
                    <label style="margin:3%">
                        <input type="radio" name="frames" value="2" id="frame2" class="framechk">
                        <img class="frameconfimg" src="./resources/interfaz/Marco2.png" alt="Option 2">
                    </label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="saveConfig" class="btn btn-primary">Guardar</button>
        </div>
        </div>
    </div>
</div>