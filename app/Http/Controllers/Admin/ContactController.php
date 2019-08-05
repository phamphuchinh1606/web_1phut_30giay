<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        $contacts = $this->contactService->getAll();
        return $this->viewAdmin('contact.index',[
            'contacts' => $contacts
        ]);
    }

    public function show($id){
        $this->contactService->updateReadContact($id);
        $contact = $this->contactService->findId($id);
        return $this->viewAdmin('contact.show',[
            'contact' => $contact
        ]);
    }
}
