<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Mahasiswa;
use Livewire\WithFileUploads;

class ListMahasiswa extends Component
{
   
    use WithFileUploads;

    public $nama, $nim, $alamat, $mahasiswa_id , $mahasiswas;
    public $isModal = 0;
    

    public function render()
    {
        $this->mahasiswas = Mahasiswa::all();
        return view('livewire.list-mahasiswa');
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function closeModal()
    {
        $this->isModal = false;
    }

    public function openModal()
    {
        $this->isModal = true;
    }

    public function resetFields()
    {
        $this->nama = '';
        $this->nim = '';
        $this->alamat = '';
    
    }

    public function store()
    {
        
        $this->validate([
            'nama' => 'required|string',
            'nim' => 'required|string',
            'alamat' => 'required|string',
            
        ]);

        Mahasiswa::updateOrCreate(['id' => $this->mahasiswa_id], [
            'nama' => $this->nama,
            'nim' => $this->nim,
            'alamat' => $this->alamat,
            
            
        ]);

    
        session()->flash('message', $this->mahasiswa_id ? $this->nama . ' Diperbaharui': $this->nama . ' Ditambahkan');
        $this->closeModal();
        $this->resetFields(); 
    }
    

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::find($id); 
        $this->mahasiswa_id = $id;
        $this->nama = $mahasiswa->nama;
        $this->nim = $mahasiswa->nim;
        $this->alamat = $mahasiswa->alamat;

        $this->openModal(); 
    }

    public function delete($id)
    {
        $mahasiswa = Mahasiswa::find($id); 
        $mahasiswa->delete(); 
        session()->flash('message', $mahasiswa->nama . ' Dihapus'); 
    }
}
