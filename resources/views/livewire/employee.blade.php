 <div class="container">
     @if ($errors->any())
         <div class="pt-3">
             <div class="alert alert-danger">
                 <ul>
                     @foreach ($errors->all() as $item)
                         <li>{{ $item }}</li>
                     @endforeach
                 </ul>
             </div>
         </div>

     @endif
     @if (session()->has('message'))
         <div class="pt-3">
             <div class="alert alert-success">
                 {{ session('message') }}
             </div>
         </div>
     @endif
     <!-- START FORM -->
     <div class="my-3 p-3 bg-body rounded shadow-sm">
         <form>
             <div class="mb-3 row">
                 <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                 <div class="col-sm-10">
                     <input type="text" class="form-control" wire:model='nama'>
                 </div>
             </div>
             <div class="mb-3 row">
                 <label for="email" class="col-sm-2 col-form-label">Email</label>
                 <div class="col-sm-10">
                     <input type="email" class="form-control" wire:model='email'>
                 </div>
             </div>
             <div class="mb-3 row">
                 <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                 <div class="col-sm-10">
                     <input type="text" class="form-control" wire:model='alamat'>
                 </div>
             </div>
             <div class="mb-3 row">
                 <label class="col-sm-2 col-form-label"></label>
                 <div class="col-sm-10">
                     @if ($updateData == false)
                         <button type="button" class="btn btn-primary" name="submit"
                             wire:click="store()">SIMPAN</button>
                     @else
                         <button type="button" class="btn btn-info" name="submit"
                             wire:click="update()">UPDATE</button>
                     @endif
                     <button type="button" class="btn btn-secondary" name="submit" wire:click="clear()">Clear</button>

                 </div>
             </div>
         </form>
     </div>
     <!-- AKHIR FORM -->

     <!-- START DATA -->
     <div class="my-3 p-3 bg-body rounded shadow-sm">
         <h1>Data Pegawai</h1>
         <div class="py-3">
             <input type="text" class="form-control mb-3 w-25" placeholder="Cari..." wire:model.live='katakunci' />

         </div>
         {{ $dataEmployees->links() }}
         <table class="table table-striped">
             <thead>
                 <tr>
                     <th class="col-md-1">No</th>
                     <th class="col-md-4">Nama</th>
                     <th class="col-md-3">Email</th>
                     <th class="col-md-2">Alamat</th>
                     <th class="col-md-2">Aksi</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($dataEmployees as $key => $item)
                     <tr>
                         <td>{{ $dataEmployees->firstItem() + $key }}</td>
                         <td>{{ $item->nama }}</td>
                         <td>{{ $item->email }}</td>
                         <td>{{ $item->alamat }}</td>
                         <td>
                             <a wire:click="edit({{ $item->id }})" class="btn btn-warning btn-sm">Edit</a>
                             <a wire:click="delete_confirm({{ $item->id }})" class="btn btn-danger btn-sm"
                                 data-bs-toggle="modal" data-bs-target="#modalId">Del</a>
                         </td>
                     </tr>
                 @endforeach

             </tbody>
         </table>
         {{ $dataEmployees->links() }}

     </div>
     <!-- AKHIR DATA -->

     <!-- Modal Body -->
     <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
     <div wire:ignore.self class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static"
         data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
         <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="modalTitleId">
                         Konfirmasi Hapus
                     </h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">Yakin Data Ini Hapus Permanen</div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                         Close
                     </button>
                     <button type="button" class="btn btn-primary" wire:click="delete()"
                         data-bs-dismiss="modal">Hapus</button>
                 </div>
             </div>
         </div>
     </div>

     <!-- Optional: Place to the bottom of scripts -->
     <script>
         const myModal = new bootstrap.Modal(
             document.getElementById("modalId"),
             options,
         );
     </script>

 </div>
