<?php
readonly class User {

    public int $id;
    public string $username;
    public string $displayname;
    public ?string $bio;
    public ?string $birthday;
    public string $password;
    public ?int $interests;


    public function __construct
    (int $id, string $username, string $displayname, string $password, ?string $bio, ?string $birthday,  ?int $interests)
    {
        $this->id = $id;
        $this->username = $username;
        $this->displayname = $displayname;
        $this->password = $password;
        $this->bio = $bio;
        $this->birthday = $birthday;
        $this->interests = $interests;
    }
}