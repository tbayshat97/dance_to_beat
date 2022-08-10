<div id="ui-alert-title">
    <div class="row">
        <div class="col s12 m4 l4" style="position: absolute;top: 50px;z-index: 9999;right: 0;">
            @if (session('success'))
            <div class="card-alert card gradient-45deg-green-teal">
                <div class="card-content white-text">
                    <p>
                        <i class="material-icons">check</i> SUCCESS : {{ session('success') }}
                    </p>
                </div>
                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
            @if (session('error'))
            <div class="card-alert card gradient-45deg-red-pink">
                <div class="card-content white-text">
                    <p>
                        <i class="material-icons">error</i> DANGER : {{ session('error') }}
                    </p>
                </div>
                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
            @if ($errors->any())
            <div class="card-alert card gradient-45deg-amber-amber">
                <div class="card-content white-text">
                    @foreach ($errors->all() as $error)
                    <p>
                        <i class="material-icons">warning</i> WARNING : {{ $error }}
                    </p>
                    @endforeach
                </div>
                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
