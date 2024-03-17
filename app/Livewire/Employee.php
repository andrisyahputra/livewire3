<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama;
    public $email;
    public $alamat;
    public $updateData = false;
    public $employee_id;
    public $katakunci;
    public $employee_selected_id = [];
    public $namaColumn = 'nama';
    public $sortDirection = 'asc';

    public function store()
    {
        $rules = [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
        ];
        $pesan = [
            'nama.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'alamat.required' => 'Alamat Wajib Diisi',
            'email.email' => 'Format Email Tidak Sesuai',
        ];
        $validate = $this->validate($rules, $pesan);
        ModelsEmployee::create($validate);
        session()->flash('message', 'Berhasil Di Tambahkan');

        $this->clear();

    }
    public function edit($id)
    {
        $data = ModelsEmployee::find($id);
        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->alamat = $data->alamat;

        $this->updateData = true;
        $this->employee_id = $id;
    }

    public function update()
    {
        $rules = [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
        ];
        $pesan = [
            'nama.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'alamat.required' => 'Alamat Wajib Diisi',
            'email.email' => 'Format Email Tidak Sesuai',
        ];
        $validate = $this->validate($rules, $pesan);
        $data = ModelsEmployee::find($this->employee_id);
        $data->update($validate);
        session()->flash('message', 'Berhasil Di Ubah');

        $this->clear();

    }
    public function clear()
    {
        $this->nama = '';
        $this->email = '';
        $this->alamat = '';

        $this->updateData = false;
        $this->employee_id = '';
        $this->employee_selected_id = [];
    }
    public function delete()
    {
        if ($this->employee_id != '') {
            $id = $this->employee_id;
            ModelsEmployee::find($id)->delete();
        }
        if (count($this->employee_selected_id) != '') {
            for ($i = 0; $i < count($this->employee_selected_id); $i++) {
                ModelsEmployee::find($this->employee_selected_id[$i])->delete();
            }
        }
        $this->clear();
        session()->flash('message', 'Berhasil Di Hapus');

    }
    public function delete_confirm($id = null)
    {
        if ($id !== null) {
            $this->employee_id = $id;
        }
    }

    public function sort($namaColumn)
    {
        $this->namaColumn = $namaColumn;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        if ($this->katakunci != null) {
            $data['dataEmployees'] = ModelsEmployee::where('nama', 'like', '%' . $this->katakunci . '%')
                ->orWhere('email', 'like', '%' . $this->katakunci . '%')
                ->orWhere('alamat', 'like', '%' . $this->katakunci . '%')
                ->orderBy($this->namaColumn, $this->sortDirection)->paginate(2);
        } else {
            $data['dataEmployees'] = ModelsEmployee::orderBy($this->namaColumn, $this->sortDirection)->paginate(2);
        }

        return view('livewire.employee', $data);
    }
}
