<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\Log;

class BarcodeGenerateController extends Controller
{
    /**
     * Product list page
     */
    public function index()
    {
        $products = Product::select('id', 'title', 'sku', 'image', 'discount_price', 'stock')->get();
        return view('backend.pages.barcode.index', compact('products'));
    }

    /**
     * Barcode modal view (AJAX loaded)
     */
    public function barcodeView($id)
    {
        try {
            // Validate ID
            if (!is_numeric($id) || $id <= 0) {
                throw new \Exception('Invalid product ID');
            }
            
            $product = Product::select('id', 'title', 'sku', 'discount_price', 'stock')->findOrFail($id);
            
            // Ensure product has required fields
            if (!$product->title) {
                throw new \Exception('Product title is missing');
            }
            
            // Generate SKU or fallback
            $code = $product->sku ?: 'PROD-' . $product->id;
            
            // Check GD extension
            if (!extension_loaded('gd')) {
                throw new \Exception('GD extension is not loaded. Please install/enable the GD extension.');
            }
            
            // Create DNS1D instance
            $dns1d = new DNS1D();
            
            // Generate barcode with proper method call
            $barcodeImage = $dns1d->getBarcodePNG($code, 'C128', 2, 60, [0, 0, 0], true);
            
            // Check if barcode was generated
            if (!$barcodeImage) {
                throw new \Exception('Failed to generate barcode image.');
            }
            
            $barcode = 'data:image/png;base64,' . $barcodeImage;
            
            // Debug logging
            \Log::info('Barcode generated successfully for product: ' . $product->title);
            
            return view('backend.pages.barcode.barcode-generate', 
                compact('product', 'barcode'))->render();
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Product not found for barcode view: ' . $id);
            return $this->getErrorHtml('Product not found');
        } catch (\Exception $e) {
            \Log::error('Barcode generation failed for product ID ' . $id . ': ' . $e->getMessage());
            return $this->getErrorHtml($e->getMessage());
        }
    }
    
    /**
     * Generate error HTML
     */
    private function getErrorHtml($errorMessage)
    {
        return '
        <div class="modal-header">
            <h5 class="modal-title text-danger">Error</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h6>Barcode Generation Failed</h6>
                <p class="mb-0">' . htmlspecialchars($errorMessage) . '</p>
                <hr>
                <small class="text-muted">
                    <strong>Troubleshooting:</strong><br>
                    1. Check if GD extension is installed and enabled in php.ini<br>
                    2. Run: php -m | grep gd (to check GD installation)<br>
                    3. For Ubuntu/Debian: sudo apt-get install php-gd<br>
                    4. For CentOS/RHEL: sudo yum install php-gd<br>
                </small>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>';
    }
}