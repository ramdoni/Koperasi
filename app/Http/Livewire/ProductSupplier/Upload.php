<?php

namespace App\Http\Livewire\ProductSupplier;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductUom;
use Livewire\WithFileUploads;

class Upload extends Component
{
    use WithFileUploads;
    public $file;
    public function render()
    {
        return view('livewire.product.upload');
    }

    public function save()
    {
        ini_set('memory_limit', '-1');
        $this->validate([
            'file'=>'required|mimes:xls,xlsx|max:51200' // 50MB maksimal
        ]);
        
        $path = $this->file->getRealPath();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $data = $reader->load($path);
        $sheetData = $data->getActiveSheet()->toArray();

        if(count($sheetData) > 0){
            $countLimit = 1;
            foreach($sheetData as $key => $i){
                if($key<=1) continue; // skip header
                
                $kategori = $i[1];
                $barcode = $i[2];
                $produk = $i[3];
                $qty = $i[4];
                $uom = $i[5];
                $price = format_idr($i[6]);
                $product = Product::where('keterangan',$produk)->first();
                if(!$product){
                    $product = new Product();
                    $product->is_migrate = 1;
                }
                $product->item_code = $barcode;
                
                if($kategori=='KONSINYASI'){
                    $product->type ='Konsinyasi';
                }else{
                    $product->type ='Stock';
                }
                $product->keterangan = $produk;
                $product->harga = $price;
                $product->harga_jual = $price;

                $product_uom = ProductUom::where('name',strtoupper($uom))->first();
                if(!$product_uom) {
                    $product_uom = new ProductUom();
                    $product_uom->name = strtoupper($uom);
                    $product_uom->save(); 
                }
                $product->product_uom_id = $product_uom->id;
                $product->qty = $qty;
                $product->save();
            }
        }

        session()->flash('message-success',__('Data berhasil di upload'));

        return redirect()->route('product.index');
    }
}