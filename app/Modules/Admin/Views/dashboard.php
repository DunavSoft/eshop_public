 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1 class="m-0">Dashboard</h1>
         </div><!-- /.col -->
       </div><!-- /.row -->
     </div><!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->

   <!-- Orders by date -->
   <section class="content">
     <div class="card card-primary card-outline">
       <div class="card-body table-responsive" id="ajax-content">
        <?php
            if (isset($ajax_view)) {
              try {
                if (is_array($ajax_view)) {
                  foreach ($ajax_view as $v) {
                    echo view($v);
                  }
                } else {
                  echo view($ajax_view);
                }
              } catch (Exception $e) {
                echo "<pre><code>$e</code></pre>";
              }
            }
            ?>
       </div>
     </div>
   </section>

 </div>
 <!-- /.content-wrapper -->