<?php
interface Email
{
    public function validateEmailStructure();
    public function validateEmailDomain();
    public function fraudEmailValidation($fraudMailList);
}
