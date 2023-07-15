<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    protected $status;
    protected $code;
    protected $message;
    protected $data;
    protected $error;

    public function __construct($status, $code, $message, $data = null, $error = null)
    {
        $this->status = $status;
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        $this->error = $error;
    }
    public function toArray(Request $request): array
    {
        if($this->error == null){
            return [
                'status' => $this->status,
                'code' => $this->code,
                'message' => $this->message,
                'data' => $this->data,
            ];
        } else {
            return [
                'status' => $this->status,
                'code' => $this->code,
                'message' => $this->message,
                'error' => $this->error,
            ];
        }
    }
}
