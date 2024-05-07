<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Festival</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
</head>
<body>
@include('sidebar')

<div class="page-content page-container mt-20" id="page-content">
    <div class="padding">
        <div class="row justify-content-center" style="padding-top: 60px; margin: 20px">
            <div class="col-md-6 col-lg-4 w-75 h-50 mt-20">
                <form class="card" action="/AssignFest" method="post" style="padding: 30px;" enctype="multipart/form-data">
                    @csrf
                    <h5 class="h3 mb-0 text-gray-800">Create Festival</h5>
                    <div class="card-body mb-30" style="margin-bottom: 20px;">
                        <div class="form-group">
                            <label class="labels">Festival Name *</label>
                            <input class="form-control" name="fest_name" id="fest_name" type="text" placeholder="" required value="{{ old('fest_name') }}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="labels">Start Date *</label>
                            <input class="form-control" name="start" id="start" type="date" placeholder="Start Date" required value="{{ old('start') }}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="labels">End Date *</label>
                            <input class="form-control" name="end" id="end" type="date" placeholder="End Date" required value="{{ old('end') }}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="labels">Image *</label>
                            <input class="form-control" type="file" id="image" name="image">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="labels">Max Team Size *</label>
                            <input class="form-control" name="maxteamsize" id="maxteamsize" min="1"  type="number" placeholder="" required value="{{ old('maxteamsize') }}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <!-- Other form fields with similar structure -->
                        <div class="form-group">
                            <label class="labels">Bronze Plan Price *</label>
                            <input class="form-control" name="pricebronze" id="pricebronze" min="1"  type="number" placeholder="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="labels">Bronze Individual Event Limit *</label>
                            <input class="form-control" name="brindlimit" id="brindlimit" min="1"  type="number" placeholder="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="labels">Bronze Group Event Limit *</label>
                            <input class="form-control" name="brgrplimit" id="brgrplimit"  min="1"  type="number" placeholder="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="labels">Silver Plan Price *</label>
                            <input class="form-control" name="pricesilver" id="pricesilver" min="1"  type="number" placeholder="">
                            <div class="invalid-feedback"></div> 
                        </div>
                        <div class="form-group">
                            <label class="labels">Silver Individual Event Limit *</label>
                            <input class="form-control" name="siindlimit" id="siindlimit" min="1"  type="number" placeholder="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="labels">Silver Group Event Limit *</label>
                            <input class="form-control" name="sigrplimit" id="sigrplimit" min="1"  type="number" placeholder="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="labels">Gold Plan Price *</label>
                            <input class="form-control" name="pricegold" id="pricegold" min="1"  type="number" placeholder="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="labels">Gold Individual Event Limit *</label>
                            <input class="form-control" name="goindlimit" id="goindlimit" min="1"  type="number" placeholder="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="labels">Gold Group Event Limit *</label>
                            <input class="form-control" name="gogrplimit" id="gogrplimit" min="1"  type="number" placeholder="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Upi Id *</label>
                            <input class="form-control" name="upi" id="upi" type="text" placeholder="upi">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-md-12">
                                <label class="labels">Upload Qr *</label>
                                <input class="form-control" type="file" id="qrcode" name="qrcode"/>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labels">Event Details *</label>
                            <textarea name="details" id="editor" cols="30" rows="10" class="form-control"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <script>
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    minHeight: '300px'
                })
                .catch(error => {
                    console.error(error);
                });
</script>
                    </div>
                    <input type="hidden" name="collegecode" value="{{ session('collegecode') }}">
                    <button class="btn btn-block btn-bold btn-primary justify-content-center" style="margin-top: 20px;">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if ($errors->any())
    <div id="notification" style="width: 300px; height: auto; background-color: #e74a3b; color: white; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
        <div style="flex: top;">
            <img src="{{ asset('/img/error.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
            <strong style="font-size: 20px; padding-right: 10px; padding-left: 5px;">Error</strong>
        </div>
        <div class="ss" style="flex-bottom; text-size: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

</body>
</html>
