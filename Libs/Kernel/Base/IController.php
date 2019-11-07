<?php

namespace Kernel\Base;

interface IController
{
    public function index() : void;
    public function new() : void;
    public function show() : void;
    public function create() : void;
    public function edit() : void;
    public function update() : void;
    public function destroy() : void;
    
}

?>