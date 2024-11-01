<?php
class dateTbp {
	static public function _($time = NULL) {
		if(is_null($time)) {
			$time = time();
		}
		return date(TBP_DATE_FORMAT_HIS, $time);
	}
}