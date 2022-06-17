<!DOCTYPE html>
 
<html lang="en">
<head>
<title>AGPay Dataset</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
</head>
      <body>
         <div class="container">
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
   <script>
   $(document).ready( function () {
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
     });
  </script>
   </body>
</html> 