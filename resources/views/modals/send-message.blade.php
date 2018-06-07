<modal name="send-message">
    <form>
        <h1 class="text-center font-italic font-weight-bold">Contactar Sitio</h1>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label text-md-right">Sitio</label>

            <div class="col-md-6">
                <select class="form-control">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Mensaje</label>

            <div class="col-md-6">
                <textarea class="form-control" rows="3"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <a class="btn btn-primary">
                    Enviar Mensaje
                </a>

                <a class="btn btn-outline-secondary" @click="$modal.hide('send-message')">
                    Cerrar
                </a>
            </div>
        </div>
    </form>
</modal>