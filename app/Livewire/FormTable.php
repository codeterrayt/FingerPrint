<?php

namespace App\Livewire;

use App\Models\ZipsData;
use Livewire\Component;

use Livewire\WithFileUploads;
use Zip;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Str;
use Illuminate\Support\Facades\Storage;
use File;

// use Illuminate\Support\Facades\Storage;

class FormTable extends Component
{

    protected $validExtensions = ['bmp', 'jpg', 'jpeg', 'png', 'gif'];

    use WithFileUploads;
    use LivewireAlert;

    public $zip;
    public $id = 1;

    public $data;

    public function mount()
    {
        $this->fetch();
    }

    private function fetch()
    {
        $this->data = ZipsData::where("user_id", auth()->id())->get();
    }

    public function save()
    {
        $this->validate([
            'zip' => 'required|file|mimes:zip|max:102400'
        ]);
        // $zipURL = $this->zip->store('zips', 'public');
        // dd($zipURL);

        // Store the ZIP file in the public storage directory
        $zipPath = $this->zip->store('zips', 'public');

        // Extract the contents of the ZIP file
        $randomDirectoryName = uniqid();
        $zip = Zip::open(storage_path('app/public/' . $zipPath));



        $extractPath = storage_path('app/public/extracted_files/' . $randomDirectoryName); // Specify the extraction directory
        $zip->extract($extractPath);

        $files = $zip->listFiles();


        // Process each file

        $currentFolder = null;
        $currentRow = null;
        $imageIndex = 1;

        // dd($files);
        foreach ($files as $entry) {




            $folderName = Str::beforeLast($entry, '/');

            // If folder changes, start a new row
            if ($folderName !== $currentFolder) {
                $currentFolder = $folderName;
                $currentRow = new ZipsData();
                $currentRow->name = explode("/", $folderName)[1];
                $currentRow->folder_id = $randomDirectoryName;
                $currentRow->user_id = auth()->id(); // Assuming you have authentication and want to associate the data with the logged-in user
                $currentRow->img_1 = null;
                $currentRow->img_2 = null;
                $currentRow->img_3 = null;
                $currentRow->img_4 = null;
                $currentRow->img_5 = null;
            }

            // Store file path in corresponding img_n attribute
            $fileName = Str::afterLast($entry, '/');

            $entry = 'extracted_files/' . $randomDirectoryName . '/' . $entry;

            if (Str::endsWith($fileName, '.bmp')) {
                if (!$currentRow->img_1) {
                    $currentRow->img_1 = $entry;
                } elseif (!$currentRow->img_2) {
                    $currentRow->img_2 = $entry;
                } elseif (!$currentRow->img_3) {
                    $currentRow->img_3 = $entry;
                } elseif (!$currentRow->img_4) {
                    $currentRow->img_4 = $entry;
                } elseif (!$currentRow->img_5) {
                    $currentRow->img_5 = $entry;
                }
            }

            $currentRow->save();
        }
        $this->fetch();
        // dd($zipPath);
        Storage::delete('public/' . $zipPath);
        $this->alert('success', 'Done..');
        $this->id++;
        $this->reset(["zip"]);
    }

    public function delete()
    {
        $folder_id = ZipsData::where("user_id", auth()->id())->first();
        if ($folder_id !== null) {
            // dd($folder_id->folder_id);
            // dd(public_path('extracted_files/'.$folder_id."/"));
            try {
                Storage::deleteDirectory('public/extracted_files/' . $folder_id->folder_id);
                $this->alert('success', 'Deleted Successfully');
            } catch (\Throwable $th) {
                $this->alert('error', 'Something Went Wrong!');

            }

            Zipsdata::where("user_id",auth()->id())->delete();
            $this->data = null;
        }else{
            $this->alert('info', 'No Data Found!');
        }
    }



    public function render()
    {
        return view('livewire.form-table');
    }
}
