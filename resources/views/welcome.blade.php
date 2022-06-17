
<!DOCTYPE html>
<html>
<head>
    <title>AGPay Load Dataset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
     
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            AGPay Load Dataset
        </div>
        <div class="card-body">
            <form id="myFormCurrency" onsubmit="return ajaxpost('currency')" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Import Currency Data</button>
            </form>
            <form id="myFormCountry" onsubmit="return ajaxpost('country')" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Import Country Data</button>
            </form>
        </div>
    </div>

    <button class="btn btn-primary" onclick="displayData('currency')">Show Currency Data</button>
    <button class="btn btn-primary" onclick="displayData('country')">Show Countries Data</button>

    <div class="currencycontainer" id="currencycontainer" style="display: none;">
               <h2>AGPay Dataset</h2>
            <table class="table table-bordered" id="currency_datatable">
               <thead>
                  <tr>
                     <th>id</th>
                     <th>iso_code</th>
                     <th>iso_numeric_code</th>
                     <th>common_name</th>
                     <th>official_name</th>
                     <th>symbol</th>
                  </tr>
               </thead>
            </table>
         </div>
         <div class="countrycontainer" id="countrycontainer"  style="display: none;">
               <h2>AGPay Dataset</h2>
            <table class="table table-bordered" id="currency_datatable">
               <thead>
                  <tr>
                     <th>Continet Code</th>
                     <th>Currency Code</th>
                     <th>iso code</th>
                     <th>iso code</th>
                     <th>iso numeric code</th>
                     <th>fips code</th>
                     <th>calling code</th>
                     <th>common name</th>
                     <th>official name</th>
                     <th>Endonym</th>
                     <th>Demonym</th>
                  </tr>
               </thead>
            </table>
         </div>
</div>

<script>
    function ajaxpost (dataset) {
                // GET FORM DATA
                var currencyForm = document.getElementById("myFormCurrency");
                var countryForm = document.getElementById("myFormCountry");
                var currencyData = new FormData(currencyForm);
                var countryForm = new FormData(countryForm);

                // post data to server, 
                if (dataset == 'currency') {
                    fetch("/api/upload-currency-content", { method:"POST", body:currencyData })
                            // show message on server response
                .then((response) => {
                    console.log(response);
                    if (response.status == "200") { alert("SUCCESSFUL!"); }
                    else { alert("FAILURE!"); }
                })
                
                // handle fetch error
                .catch((err) => { console.error(err); });
                //prevent form submit
                return false;

            } else {
                fetch("/api/upload-country-content", { method:"POST", body:countryForm }) 
                        // show message on server response
                .then((response) => {
                    console.log(response);
                    if (response.status == "200") { alert("SUCCESSFUL!"); }
                    else { alert("FAILURE!"); }
                })
                // handle fetch error
                .catch((err) => { console.error(err); });
                        
                //prevent form submit
                return false;
        }

    }

    function displayData(dataset) {
        var currencyEl = document.getElementById("currencycontainer");
        var countryEl = document.getElementById("countrycontainer");

        if (dataset == "currency") {

            currencyEl.style.display = "block";
            countryEl.style.display = "none";

            $('#currency_datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('api/display-currency-content') }}",
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'iso_code', name: 'iso_code' },
                    { data: 'iso_numeric_code', name: 'iso_numeric_code' },
                    { data: 'common_name', name: 'common_name' },
                    { data: 'official_name', name: 'official_name' },
                    { data: 'symbol', name: 'symbol' }
            ]
        });

        } else {

            currencyEl.style.display = "none";
            countryEl.style.display = "block";

            $('#country_datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('api/display-country-content') }}",
           columns: [
                    { data: 'continent_code', name: 'continent_code' },
                    { data: 'currency_code', name: 'currency_code' },
                    { data: 'iso2_code', name: 'iso2_code' },
                    { data: 'iso3_code', name: 'iso3_code' },
                    { data: 'iso_numeric_code', name: 'iso_numeric_code' },
                    { data: 'fips_code', name: 'fips_code' },
                    { data: 'calling_code', name: 'calling_code' },
                    { data: 'common_name', name: 'common_name' },
                    { data: 'official_name', name: 'official_name' },
                    { data: 'endonym', name: 'endonym' },
                    { data: 'demonym', name: 'demonym' },
            ]
        });
        }


    }
</script>
    
</body>
</html>