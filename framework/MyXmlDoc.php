<?php
/*
 * Wrapper delle funzioni di php5 per php4
 *
 *
 */
class MyXmlDoc
{
	/*
	 * DOMDocument
	 * @private
	 */
	var $dom = null;
	
	// nodo root
	var $documentElement = null;
	
	function load($nomeFileXml)
	{
		//var_dump($nomeFileXml);
		//var_dump(domxml_open_file($nomeFileXml));
		if (!$this->dom = domxml_open_file(realpath($nomeFileXml)))
			// @todo Al posto di utente??
			// @dubbio: Error è del framework o di universibo?
			Error :: throwError(_ERROR_CRITICAL, array ('id_utente' => '', 'msg' => 'Errore nel lettura del file di configurazione', 'file' => __FILE__, 'line' => __LINE__));
				
		$this->documentElement = new MyDomElement($this->dom->document_element());	
	}

	/*
	 * in PHP5 ritorna un DOM Node list invece che un array
	 *
     * cioé:
	 * $element->item(0) invece che $element[0].
	 *
	 * @return MyDOMNodeList
	 */
	function getElementsByTagName($nomeTag)
	{
		return new MyDOMNodeList($this->dom->get_elements_by_tagname($nomeTag));
	}
}

//// mi conviene creare questa classe?
//class MyDomNode
//{
//	var $realElement =null;
//	
//	// Inizio proprietà pubbliche stile PHP5
//	var $nodeValue = null;
//
//	var $firstChild = null;
//
//	var $nodeType = null;
//
//	var $childNodes = null;
//
//	var $tagName = null;
//	
//	// non so se è proprietà php 5
//	var $attributes = null;
//
//	function MyDomNode($domNode)
//	{
//		// si può controllare se $domElement è effetivamente un oggetto DomElement?
//		if ($domNode == null)
//			// Error o meglio return null? ci creiamo le Exception?
//			Error :: throwError(_ERROR_CRITICAL, array ('id_utente' => '', 'msg' => 'Errore nella creazione del nodo', 'file' => __FILE__, 'line' => __LINE__));
//			
//		$this->realElement 	=& $domNode;
//		
//		//var_dump($this->realElement);
//		// node_value è definito solo per le foglie?
////		if ( $this->realElement->node_type() == XML_TEXT_NODE ) 
////		{
////			$this->nodeValue	=& $this->realElement->node_value();
////		}	
//
//		$this->nodeValue	=& $this->realElement->node_value();
//		
////		$child = $this->realElement->first_child();
////		if ($child != null)
////			$this->firstChild	=& new MyDomElement ($child);
//		if ($this->realElement->has_child_nodes())
//			$this->firstChild	=& new MyDomNode ($this->realElement->first_child());
//			
////		$childs = $this->realElement->child_nodes();
////		if ($childs != null)
////			$this->childNodes	=& new MyDOMNodeList($childs);
//		
////		if ($this->realElement->has_child_nodes())
//			$this->childNodes	=& new MyDOMNodeList ($this->realElement->child_nodes());
//		
//		$this->tagName	=& $this->realElement->node_name();
//		
//		$this->nodeType =& $this->realElement->node_type();
//		
//		// @TODO cercare il nome della funz per accedere agli attributi...
//		$this->attributes =& $this->realElement->attributes();
//		var_dump($this->realElement->attributes());
//	}
//	
//}

class MyDomElement
{
	var $realElement =null;
	
	// Inizio proprietà pubbliche stile PHP5
	var $nodeValue = null;

	var $firstChild = null;

	var $nodeType = null;

	var $childNodes = null;

	var $tagName = null;

	function MyDomElement($domElement)
	{
		// si può controllare se $domElement è effetivamente un oggetto DomElement?
		if ($domElement == null)
			// Error o meglio return null? ci creiamo le Exception?
			Error :: throwError(_ERROR_CRITICAL, array ('id_utente' => '', 'msg' => 'Errore nella creazione del nodo', 'file' => __FILE__, 'line' => __LINE__));
			
		$this->realElement 	=& $domElement;
		
		//var_dump($this->realElement);
		// node_value è definito solo per le foglie?
//		if ( $this->realElement->node_type() == XML_TEXT_NODE ) 
//		{
//			$this->nodeValue	=& $this->realElement->node_value();
//		}	

		$this->nodeValue	=& $this->realElement->node_value();
		
//		$child = $this->realElement->first_child();
//		if ($child != null)
//			$this->firstChild	=& new MyDomElement ($child);
		if ($this->realElement->has_child_nodes())
			$this->firstChild	=& new MyDomElement ($this->realElement->first_child());
			
//		$childs = $this->realElement->child_nodes();
//		if ($childs != null)
//			$this->childNodes	=& new MyDOMNodeList($childs);
		
		if ($this->realElement->has_child_nodes())
			$this->childNodes	=& new MyDOMNodeList ($this->realElement->child_nodes());
		
		// @TODO cercare il nome della funz per accedere al tagname
		$this->tagName	=& $this->realElement->node_name();
		
		$this->nodeType =& $this->realElement->node_type();
		
	}
	
	/*
	 * in PHP5 ritorna un DOM Node list invece che un array
	 *
     * cioé:
	 * $element->item(0) invece che $element[0].
	 *
	 * @return MyDOMNodeList
	 */
	function getElementsByTagName($nomeTag)
	{
		return new MyDOMNodeList($this->realElement->get_elements_by_tagname($nomeTag));
	}
	
	function getAttribute($nomeAttr)
	{	
//		if ($this->realElement->type == 1)
			return $this->realElement->get_attribute($nomeAttr);
//		var_dump($this->realElement);
//		var_dump(debug_backtrace());
//		return '';
	}
}

// riesco a farlo considerare anche come array in modo da scorrerlo con il foreach?
class MyDOMNodeList
{
	var $arrayDiElementi = null;

	// proprietà interfaccia Array
	var $length = 0;
	
	function MyDOMNodeList($listaElementi)
	{
		// @dubbio: controllo input
		$listaAppoggio =& $listaElementi;	
		
		$this->arrayDiElementi = array();

		foreach ( $listaAppoggio as $elemento)
		{
			$this->arrayDiElementi[] =& new MyDomElement($elemento);
		}
		
		$this->length = count($this->arrayDiElementi);
		//var_dump($this->arrayDiElementi);
	}

	function item($indice)
	{
		// @dubbio: controllo che $indice sia valore corretto?
		if ($indice >= 0 && $indice < $this->length)
			return $this->arrayDiElementi[$indice];
		else return null;		// @dubbio: oppure lancio errore?
	}
}

//// mmm dovrei estendere l'object che php restituisce con document_element()
//// oppure mi faccio passare direttamente quell'object e nel costruttore  wrappo i metodi in proprietà
//class MyXmlNode
//{
//	var $parentNode;
//	
//	//array
//	var $childNodes;
//	
//	var $firstChild;
//	
//	var $lastChild;
//	
//	var $previousSibling;
//	
//	var $nextSibling;
//	
//	function MyXmlNode ($docElement)
//	{
//		$this->parentNode = $docElement->parent_node();
//		// prima occorre controllo se ha figli o meno?
//		$this->childNodes = $docElement->child_nodes();
//		$this->firstChild = $docElement->first_child();
//		$this->lastChild  = $docElement->last_child();
//		$this->previousSibling = $docElement->previous_sibling();
//		$this->nextSibling = $docElement->next_sibling();
//	}
//}
?>