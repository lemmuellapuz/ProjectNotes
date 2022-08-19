<div class="shadow">
    <div class="d-flex justify-content-between align-items-center">
    
        <div id="left">
            <h1>Project Notes</h1>
        </div>

        <div id="right">

            <div class="row">
                <div class="col-4">
                    {{ Auth::user()->name }}
                </div>

                <div class="col-8">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="submit" value="Logout" class="btn btn-danger">
                    </form>
                </div>
            </div>

        </div>


    </div>

    
</div>