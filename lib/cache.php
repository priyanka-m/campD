<?php
	Class Cache {
	
		public function __construct() {
			$memcache = new Memcache;
			$memcache->connect(MEMCACHED_HOST, MEMCACHED_PORT);
			return $memcache;
		}

		public function connect() {
			$memcache = new Memcache;
			$memcache->connect(MEMCACHED_HOST, MEMCACHED_PORT);
			return $memcache;
		}

		public function set($key, $value) {
			$memcache = $this->connect();
			$memcache->set($key, $value, false, 30);
			$memcache->close();
		}

		public function get($key) {
			$memcache = $this->connect();
			$value = $memcache->get($key);
			$memcache->close();
			return $value;
		}

		public function replace($key, $new_value) {
			$memcache = $this->connect();
			$memcache->replace($key, $new_value, false, 30);
			$memcache->close();	
		}

		public function delete($key) {
			$memcache = $this->connect();
			$memcache->delete($key);
			$memcache->close();	
		}
	}
?>