<?php
/**
 * Content:
 *	Class to stemmer german words.
 *	This was original a drupal module to improve searching in german texts (Porter stemmer)
 *	Algorithm based on http://snowball.tartarus.org/algorithms/german/stemmer.html
 * Author:
 *	Reiner Miericke		10.10.2007
 *	Valentin Zickner	02.06.2011
 * References:
 *	Algorithm:
 *		http://www.clef-campaign.org/workshop2002/WN/3.pdf
 *		http://w3.ub.uni-konstanz.de/v13/volltexte/2003/996//pdf/scherer.pdf
 *		http://kontext.fraunhofer.de/haenelt/kurs/Referate/Kowatschew_Lang/stemming.pdf
 *		http://www.cis.uni-muenchen.de/people/Schulz/SeminarSoSe2001IR/FilzmayerMargetic/referat.html
 *		http://www.ifi.unizh.ch/CL/broder/mue1/porter/stemming/node1.html
 *		For lists of stopwords see
 *		http://members.unine.ch/jacques.savoy/clef/index.html
 *	Small parts were stolen from dutchstemmer.module
*/


// Sûp-Steffensdag

class Tx_HelfenKannJeder_Service_StemmerService implements t3lib_Singleton {
	// global variables to hold lists of words
	const DE_STEMMER_VOKALE = 'aeiouyäöü';
	const DE_WORT_MUSTER = '/^[a-zßäöü]+$/';
	const DE_LITERAL_MUSTER = '/([^a-zA-ZÄÖÜßäëïöüáéíóúèû])/';

	private $stopwords = array();
	private $exceptions = array();

	private function _split_text(&$text) {
		$text = $this->_punctuation($text);

		// Split words from noise
		return preg_split(self::DE_LITERAL_MUSTER, $text, -1, PREG_SPLIT_NO_EMPTY);
	}

        // "-" am Wortende entfernen
	// Achtung! Beisst sich mit search_simplify. Siehe
	//     The dot, underscore and dash are simply removed ...
	private function _punctuation(&$text) {
		return preg_replace('/([a-zA-ZÄÖÜßäëïöüáéíóúèû]{3,})[-_\/](?=[0-9a-zA-ZÄÖÜßäëïöüáéíóúèû])/u','\1 ',$text);
	}

	/**
	 * Implementation of hook_search_preprocess
	 */
	public function search_preprocess($text) {
		$text = strtolower($text);
		$text = $this->_punctuation($text);

		// Split words from noise and remove apostrophes
		$words = preg_split(self::DE_LITERAL_MUSTER, $text, -1, PREG_SPLIT_DELIM_CAPTURE);

		// Process each word
		$w_cnt = 0;   // number of words (should be > 0)
		$odd = true;
		foreach ($words as $k => $word) {
			if ($odd) {
				if (!$this->_stoppwort($word)) {
					$words[$k] = $this->_wortstamm($word);
					++$w_cnt;
				} else {
					$words[$k] = '';
				}
			}
			$odd = !$odd;
		}

		if (!$w_cnt) {        // no words left
			$words[1] = '_';
		}
		// Put it all back together
		return implode('', $words);
	}

	/*
	 * Function gets as text (parameter) and splits the text into words.
	 * Then each word is stemmed and the word together with its stem is
	 * stored in an array (hash). 
	 * As a result the hash is returned and can be used as a lookup table
	 * to identify words which transform to the same stem.
	 * For details please compare 'search.module-stem.patch'
	 */
	public function stemList(&$text) {
		// Split words from noise and remove apostrophes
		$words = $this->_split_text($text);

		$stem_list = array();
		foreach ($words as $word) {
			$stem_list[$word] = $this->_wortstamm(strtolower($word));
		}
		return $stem_list;
	}

	private function _region_n($wort) {
		$r = strcspn($wort, self::DE_STEMMER_VOKALE);
		return $r + strspn($wort, self::DE_STEMMER_VOKALE, $r) + 1;
	}

	public function stem_preprocess($wort) {
		$wort = strtolower($wort);
		$wort = str_replace("ß", "ss", $wort);
		// replace ß by ss, and put u and y between vowels into upper case
		$wort = preg_replace(  array(  '/ß/',
				'/(?<=['. self::DE_STEMMER_VOKALE .'])u(?=['. self::DE_STEMMER_VOKALE .'])/u',
				'/(?<=['. self::DE_STEMMER_VOKALE .'])y(?=['. self::DE_STEMMER_VOKALE .'])/u'
			),
			array(  'ss', 'U', 'Y'  ),
			$wort
		);

		return $wort;
	}

	private function _stem_postprocess($wort) {
		$wort = strtolower($wort);

		if (!$this->_ausnahme($wort)) {	// check for exceptions
			$wort = strtr($wort, array(	'ä' => 'a', 'á' => 'a',
							'ë' => 'e', 'é' => 'e', 
							'ï' => 'i', 'í' => 'i',
							'ö' => 'o', 'ó' => 'o',
							'ü' => "u", 'ú' => 'u', 'û' => 'u'
			));
		}
		return $wort;
	}


	private function _wortstamm($wort) {
		// nur deutsche Worte folgen diesen Regeln
		if ( !preg_match(self::DE_WORT_MUSTER,$wort) ) {
			return $wort;
		}

		$stamm = $this->stem_preprocess($wort);

		$umlaut = preg_match('/[äöüÄÖÜ]/', $wort); 

		/*
		 * * R1 is the region after the first non-vowel following a vowel, 
		 *   or is the null region at the end of the word if there is no such non-vowel.
		 * * R2 is the region after the first non-vowel following a vowel in R1, 
		 *   or is the null region at the end of the word if there is no such non-vowel.
		 */

		$l = strlen($stamm);
		$r1 = $this->_region_n($stamm);
		$r2 = $r1 == $l  ?  $r1  :  $r1 + $this->_region_n(substr($stamm, $r1));
		// unshure about interpreting the following rule:
		// "then R1 is ADJUSTED so that the region before it contains at least 3 letters"
		if ($r1 < 3) {
			$r1 = 3;
		}
  
		/*
		 * Step 1
		 * Search for the longest among the following suffixes,
		 *	(a) e   em   en   ern   er   es
		 *	(b) s (preceded by a valid s-ending) 
		 *	    and delete if in R1. 
		 * (Of course the letter of the valid s-ending is not necessarily in R1)
		 */

		if (preg_match('/(e|em|en|ern|er|es)$/u', $stamm, $hits, PREG_OFFSET_CAPTURE, $r1)) {
			$stamm = substr($stamm, 0, $hits[0][1] - $umlaut);
		}
		elseif (preg_match('/(?<=(b|d|f|g|h|k|l|m|n|r|t))s$/u', $stamm, $hits, PREG_OFFSET_CAPTURE, $r1)) {
			$stamm = substr($stamm, 0, $hits[0][1] - $umlaut);
		}

		/*
		 * Step 2
		 * Search for the longest among the following suffixes,
		 *	(a) en   er   est
		 *	(b) st (preceded by a valid st-ending, itself preceded by at least 3 letters) 
		 *	    and delete if in R1. 
		 */

		if (preg_match('/(en|er|est)$/u', $stamm, $hits, PREG_OFFSET_CAPTURE, $r1)) {
			$stamm = substr($stamm, 0, $hits[0][1] - $umlaut);
		}
		elseif (preg_match('/(?<=(b|d|f|g|h|k|l|m|n|t))st$/u', $stamm, $hits, PREG_OFFSET_CAPTURE, $r1)) {
			$stamm = substr($stamm, 0, $hits[0][1] - $umlaut);
		}


		/*
		 * Step 3: d-suffixes ( see http://snowball.tartarus.org/texts/glossary.html )
		 *	Search for the longest among the following suffixes, and perform the action indicated.
		 *      end   ung
		 *    delete if in R2 
		 *    if preceded by ig, delete if in R2 and not preceded by e
		 *      ig   ik   isch
		 *    delete if in R2 and not preceded by e
		 *      lich   heit
		 *    delete if in R2 
		 *    if preceded by er or en, delete if in R1
		 *      keit
		 *    delete if in R2 
		 *    if preceded by lich or ig, delete if in R2 
		 *                                             ^ means R1 ?
		 */
		if (preg_match('/(?<=eig)(end|ung)$/u', $stamm, $hits, PREG_OFFSET_CAPTURE, $r2)) {
			;
		}
		elseif (preg_match('/(end|ung)$/u', $stamm, $hits, PREG_OFFSET_CAPTURE, $r2)) {
			$stamm = substr($stamm, 0, $hits[0][1] - $umlaut);
		}
		elseif (preg_match('/(?<![e])(ig|ik|isch)$/u', $stamm, $hits, PREG_OFFSET_CAPTURE, $r2)) {
			$stamm = substr($stamm, 0, $hits[0][1] - $umlaut);
		}
		elseif (preg_match('/(?<=(er|en))(lich|heit)$/u', $stamm, $hits, PREG_OFFSET_CAPTURE, $r1)) {
			$stamm = substr($stamm, 0, $hits[0][1] - $umlaut);
		}
		elseif (preg_match('/(lich|heit)$/u', $stamm, $hits, PREG_OFFSET_CAPTURE, $r2)) {
			$stamm = substr($stamm, 0, $hits[0][1] - $umlaut);
		}
		elseif (preg_match('/(?<=lich)keit$/u', $stamm, $hits, PREG_OFFSET_CAPTURE, $r1)) {
			$stamm = substr($stamm, 0, $hits[0][1] - $umlaut);
		}
		elseif (preg_match('/(?<=ig)keit$/u', $stamm, $hits, PREG_OFFSET_CAPTURE, $r1)) {
			$stamm = substr($stamm, 0, $hits[0][1] - $umlaut);
		}
		elseif (preg_match('/keit$/u', $stamm, $hits, PREG_OFFSET_CAPTURE, $r2)) {
			$stamm = substr($stamm, 0, $hits[0][1] - $umlaut);
		}

		/* Was ist mit
		 * chen, lein, bar, schaft, ... ?
		 */
		return $this->_stem_postprocess($stamm);
	}


	private function _stoppwort($wort) {
		return in_array($wort, $this->stopwords);
	}

	/*
	 * first try to set up a list of exceptions
	 */
	private function _ausnahme(&$wort) {
		if ( array_key_exists($wort, $this->exceptions) ) {
			$wort = $this->exceptions[$wort];
			return TRUE;
		}
		return FALSE;
	}
}
