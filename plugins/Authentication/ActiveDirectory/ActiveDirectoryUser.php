<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class ActiveDirectoryUser
{
	private $fname;
	private $lname;
	private $mail;
	private $phone;
	private $institution;
	private $title;
	private $mapping;

	/**
	 * @param adLDAPUserCollection $entry
	 * @param string[]|array $mapping
	 */
	public function __construct($entry, $mapping)
	{
		$this->mapping = $mapping;

		$this->fname = $this->Get($entry, 'givenname');//$entry->givenname;
		$this->lname = $this->Get($entry, 'sn');
		$this->mail = strtolower($this->Get($entry, 'mail'));
		$this->phone = $this->Get($entry, 'telephonenumber');
		$this->institution = $this->Get($entry, 'physicaldeliveryofficename');
		$this->title = $this->Get($entry, 'title');
	}

	public function GetFirstName()
	{
		return $this->fname;
	}

	public function GetLastName()
	{
		return $this->lname;
	}

	public function GetEmail()
	{
		return $this->mail;
	}

	public function GetPhone()
	{
		return $this->phone;
	}

	public function GetInstitution()
	{
		return $this->institution;
	}

	public function GetTitle()
	{
		return $this->title;
	}

	public function __toString()
	{
		return sprintf('ActiveDirectoryUser - First Name: %s, Last Name: %s, Email: %s, Phone: %s, Institution: %s, Title: %s',
			$this->fname,
			$this->lname,
			$this->mail,
			$this->phone,
			$this->institution,
			$this->title);
	}

	private function Get($entry, $field)
	{
		$actualField = $field;
		if (array_key_exists($field, $this->mapping))
		{
			$actualField = $this->mapping[$field];
		}
		$value = $entry->$actualField;

		if (is_array($value))
		{
			return $value[0];
		}

		return $value;
	}

}

?>