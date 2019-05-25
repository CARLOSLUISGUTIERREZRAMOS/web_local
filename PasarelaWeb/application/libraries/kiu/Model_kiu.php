<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_kiu {

    protected $EchoToken = 1;
    protected $TimeStamp;
    protected $Sine = 'LIM002IWW';
    protected $Device = 'LIM002IX01';
    protected $Target = 'Testing';
//    protected $Target = 'Production';
    protected $SequenceNmbr = 1;
    private $ObjConnectionkiu;

    function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->library('kiu/Connection_kiu');

        $this->ObjConnectionkiu = new Connection_kiu();
    }

    public function Model_AirAvailRQ($args) {
        $default = array("Direct" => "", "Fecha_salida" => "", "Fecha_retorno" => "", "Source" => "", "Dest" => "", "TipoVuelo" => "", "Cabin" => "", "QuantityADT" => "", "QuantityCNN" => "", "QuantityINF" => "");
        extract(array_merge($default, $args));
        $request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<KIU_AirAvailRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\" DirectFlightsOnly=\"$Direct\">
	<POS>
		<Source AgentSine=\"$this->Sine\" TerminalID=\"$this->Device\">
		</Source>
	</POS>
	<OriginDestinationInformation>
		<DepartureDateTime>$Fecha_salida</DepartureDateTime>
		<OriginLocation LocationCode=\"$Source\"/>
		<DestinationLocation LocationCode=\"$Dest\"/>
	</OriginDestinationInformation>";
        if ($TipoVuelo === 'R') {

            $request .= "<OriginDestinationInformation>
                            <DepartureDateTime>$Fecha_retorno</DepartureDateTime>
                            <OriginLocation LocationCode=\"$Dest\" />
                            <DestinationLocation LocationCode=\"$Source\" />
                    </OriginDestinationInformation>";
        }
        $request .= "<TravelPreferences >
		<CabinPref Cabin=\"$Cabin\"/>
	</TravelPreferences>
	<TravelerInfoSummary>
		<AirTravelerAvail>
			<PassengerTypeQuantity Code=\"ADT\" Quantity=\"$QuantityADT\"/>
                        <PassengerTypeQuantity Code=\"CNN\" Quantity=\"$QuantityCNN\"/>
                         <PassengerTypeQuantity Code=\"INF\" Quantity=\"$QuantityINF\"/>
		</AirTravelerAvail>
	</TravelerInfoSummary>
</KIU_AirAvailRQ>";
        $this->ObjConnectionkiu->Connection();
        $response = $this->ObjConnectionkiu->SendMessage($request);
        if ($this->ObjConnectionkiu->GetErrorCode() != 0)
            $response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";

        $array = array();
        $array[] = simplexml_load_string($response);
        $array[] = htmlspecialchars($request, ENT_QUOTES);
        $array[] = htmlspecialchars($response, ENT_QUOTES);
        $array[] = new SimpleXMLElement($response);
        return $array;
//        return simplexml_load_string($response);
    }

    public function Model_AirBookRQ($args) {
        $default = array('City' => '', 'Country' => '', 'Currency' => '', 'FlightSegment' => array()
            , 'Passengers' => array(), 'Telefono' => '', 'CodigoAreaTel' => '', 'Celular' => '', 'CodigoAreaCel' => '', 'Remark' => '', 'TiempoExpiracionReserva' => '');
        extract(array_merge($default, $args));
        $request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <KIU_AirBookRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\">
            <POS>
		<Source AgentSine=\"$this->Sine\" PseudoCityCode=\"$City\" ISOCountry=\"$Country\" ISOCurrency=\"$Currency\" TerminalID=\"$this->Device\">
			<RequestorID Type=\"5\"/>
			<BookingChannel Type=\"1\"/>
		</Source>
            </POS>
            <AirItinerary>
		<OriginDestinationOptions>
                        <OriginDestinationOption>";
        foreach ($FlightSegment as $item) {

            $ddatetime = $item["DepartureDateTime"];
            $adatetime = $item["ArrivalDateTime"];
            $flight = $item["FlightNumber"];
            $class = $item["ResBookDesigCode"];
            $source = $item["DepartureAirport"];
            ;
            $dest = $item["ArrivalAirport"];
            $airline = $item["MarketingAirline"];

            $request .= "<FlightSegment DepartureDateTime=\"$ddatetime\" ArrivalDateTime=\"$adatetime\" FlightNumber=\"$flight\" ResBookDesigCode=\"$class\" >
                                                <DepartureAirport LocationCode=\"$source\"/>
                                                <ArrivalAirport LocationCode=\"$dest\"/>
                                                <MarketingAirline Code=\"$airline\"/>
                                            </FlightSegment>";
        }

        $request .= "</OriginDestinationOption>
		</OriginDestinationOptions>
	</AirItinerary>
                    <TravelerInfo>";
        $i = 1;
        $k = 0;
        foreach ($Passengers as $item) {

            $PassengerType = $item["Tipo_Pasajero"];
            $GivenName = $item["Nombres"];
            $Surname = $item["Apellidos"];
            $Email = $item["Email"];
            $DocID = $item["Numero_Documento"];
            $DocType = $item["Tipo_Documento"];

            $request .= "<AirTraveler PassengerTypeCode=\"$PassengerType\">
                                            <PersonName>
                                                    <GivenName>$GivenName</GivenName>
                                                    <Surname>$Surname</Surname>
                                            </PersonName>";
            if ($k == 0) {
                $request .= "<Telephone AreaCityCode=\"$CodigoAreaTel\" PhoneNumber=\"$Telefono\"/>
                                                             <Telephone AreaCityCode=\"$CodigoAreaCel\" PhoneNumber=\"$Celular\"/>";
                $k++;
            }

            $request .= "<Email>$Email</Email>
                                            <Document DocID=\"$DocID\" DocType=\"$DocType\"></Document>
                                            <TravelerRefNumber RPH=\"$i\"/>
                                    </AirTraveler>";
            $i++;
        }
        $request .= "<SpecialReqDetails>
                                <Remarks>";

        if (trim($Remark) != '') {
            $request .= "
                                <Remark>$Remark</Remark>";
        }
        $request .= "</Remarks></SpecialReqDetails>";
        $request .= "</TravelerInfo>
	<Ticketing TicketTimeLimit=\"$TiempoExpiracionReserva\" />
	
</KIU_AirBookRQ>";

        $this->ObjConnectionkiu->Connection();
        $response = $this->ObjConnectionkiu->SendMessage($request);
        if ($this->ObjConnectionkiu->GetErrorCode() != 0)
            $response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";

        $array = array();
        $array[] = simplexml_load_string($response);
        $array[] = htmlspecialchars($request, ENT_QUOTES);
        $array[] = htmlspecialchars($response, ENT_QUOTES);
        $array[] = new SimpleXMLElement($response);
        return $array;
    }

    public function Model_AirPriceRQ($args) {
        $default = array('City' => '', 'Country' => '', 'Currency' => '', 'FlightSegment' => array()
            , 'PassengerQuantityADT' => 0, 'PassengerQuantityCNN' => 0, 'PassengerQuantityINF' => 0
            , 'GivenName' => '', 'Surname' => '', 'PhoneNumber' => '', 'Email' => '', 'DocID' => '', 'DocType' => '', 'Remark' => '');
        extract(array_merge($default, $args));
        $request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                <KIU_AirPriceRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\">
                    <POS>
                        <Source AgentSine=\"$this->Sine\" PseudoCityCode=\"$City\" ISOCountry=\"$Country\" ISOCurrency=\"$Currency\" TerminalID=\"$this->Device\">
                            <RequestorID Type=\"5\"/>
                            <BookingChannel Type=\"1\"/>
                        </Source>
                    </POS>
                <AirItinerary>
                    <OriginDestinationOptions>
                    <OriginDestinationOption>";

        foreach ($FlightSegment as $item) {
            $ddatetime = $item["DepartureDateTime"];
            $adatetime = $item["ArrivalDateTime"];
            $flight = $item["FlightNumber"];
            $class = $item["ResBookDesigCode"];
            $source = $item["DepartureAirport"];
            ;
            $dest = $item["ArrivalAirport"];
            $airline = $item["MarketingAirline"];
            $request .= "<FlightSegment DepartureDateTime=\"$ddatetime\" ArrivalDateTime=\"$adatetime\" FlightNumber=\"$flight\" ResBookDesigCode=\"$class\" >
					<DepartureAirport LocationCode=\"$source\"/>
					<ArrivalAirport LocationCode=\"$dest\"/>
					<MarketingAirline Code=\"$airline\"/>
                                    </FlightSegment>";
        }
        $request .= "</OriginDestinationOption>
		</OriginDestinationOptions>
        </AirItinerary>
        <TravelerInfoSummary>
        <AirTravelerAvail>";
        if ($PassengerQuantityADT > 0)
            $request .= "<PassengerTypeQuantity Code=\"ADT\" Quantity=\"$PassengerQuantityADT\"/>";
        if ($PassengerQuantityCNN > 0)
            $request .= "<PassengerTypeQuantity Code=\"CNN\" Quantity=\"$PassengerQuantityCNN\"/>";
        if ($PassengerQuantityINF > 0)
            $request .= "<PassengerTypeQuantity Code=\"INF\" Quantity=\"$PassengerQuantityINF\"/>";
        $request .= "</AirTravelerAvail>
        </TravelerInfoSummary>
        </KIU_AirPriceRQ>";

        $this->ObjConnectionkiu->Connection();
        $response = $this->ObjConnectionkiu->SendMessage($request);
        if ($this->ObjConnectionkiu->GetErrorCode() != 0)
            $response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";
        $array = array();
        $array[] = simplexml_load_string($response);
        $array[] = htmlspecialchars($request, ENT_QUOTES);
        $array[] = htmlspecialchars($response, ENT_QUOTES);
        $array[] = new SimpleXMLElement($response);
        return $array;
    }

    public function Model_AirDemandTicketRQ($args) {
        $default = array('PaymentType' => '', 'Country' => '', 'Currency' => '', 'TourCode' => '', 'BookingID' => ''
            , 'CreditCardCode' => '', 'CreditCardNumber' => '', 'CreditSeriesCode' => '', 'CreditExpireDate' => '', 'DebitCardCode' => ''
            , 'DebitCardNumber' => '', 'DebitSeriesCode' => '', 'InvoiceCode' => '', 'MiscellaneousCode' => '', 'Text' => '', 'VAT' => '');
        extract(array_merge($default, $args));
        $request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<KIU_AirDemandTicketRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\">
	<POS>
		<Source AgentSine=\"$this->Sine\" TerminalID=\"$this->Device\" ISOCountry=\"$Country\" ISOCurrency=\"$Currency\">
			<RequestorID Type=\"5\"/>
			<BookingChannel Type=\"1\"/>
		</Source>
	</POS>
	<DemandTicketDetail TourCode=\"$TourCode\">
	<BookingReferenceID ID=\"$BookingID\">
		<CompanyName Code=\"2I\"/>
	</BookingReferenceID>";
        switch ($PaymentType) {
            case 5:
                $request .= "
	<PaymentInfo PaymentType=\"5\">
	<CreditCardInfo CardType=\"1\" CardCode=\"$CreditCardCode\" CardNumber=\"$CreditCardNumber\" SeriesCode=\"$CreditSeriesCode\" ExpireDate=\"$CreditExpireDate\"/>
	";
                break;

            case 6:
                $request .= "
	<PaymentInfo PaymentType=\"6\">
	<CreditCardInfo CardType=\"1\" CardCode=\"$DebitCardCode\" CardNumber=\"$DebitCardNumber\" SeriesCode=\"$DebitSeriesCode\" />
	";
                break;

            case 34:
                $request .= "
	<PaymentInfo PaymentType=\"34\" InvoiceCode=\"$InvoiceCode\">
	";
                break;
            case 37: // ID RESERVA -> TBL reserva | SP => codigo de safetypay
                $request .= "
	<PaymentInfo PaymentType=\"37\" MiscellaneousCode=\"$MiscellaneousCode\" Text=\"$Text\">
	";
                break;
            case 1:
                $request .= "
	<PaymentInfo PaymentType=\"1\">
	";
                break;
        }
        $request .= "<ValueAddedTax VAT=\"$VAT\"/>
	</PaymentInfo>
	<Endorsement Info=\"\"/>
	</DemandTicketDetail>
</KIU_AirDemandTicketRQ>";

        $this->ObjConnectionkiu->Connection();
        $response = $this->ObjConnectionkiu->SendMessage($request);
        if ($this->ObjConnectionkiu->GetErrorCode() != 0)
            $response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";

        $array = array();
        $array[] = simplexml_load_string($response);
        $array[] = htmlspecialchars($request, ENT_QUOTES);
        $array[] = htmlspecialchars($response, ENT_QUOTES);
        $array[] = new SimpleXMLElement($response);
        return $array;

//        return simplexml_load_string($response);
//return $request;
    }

    public function Model_TravelItineraryReadRQ($args) {
        $default = array('IdTicket' => '', 'Email' => '', 'CodReserva' => '');
        extract(array_merge($default, $args));
        $request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<KIU_TravelItineraryReadRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\">
	<POS>
		<Source AgentSine=\"$this->Sine\" TerminalID=\"$this->Device\"></Source>
	</POS>";
        if ($CodReserva != '') {
            $request .= " <UniqueID Type=\"14\" ID=\"$CodReserva\"></UniqueID>";
        }
        if ($IdTicket != '') {
            $request .= " <UniqueID Type=\"30\" ID=\"$IdTicket\"></UniqueID>";
        }
        if ($Email != '') {
            $request .= "<Verification>
                            <Email>$Email</Email> 
                        </Verification>";
        }
        if ($IdTicket != '' && $CodReserva == '' && $Email == '') {
            $request .= "<Ticketing TicketTimeLimit=\"1\" />";
        }

        $request .= "</KIU_TravelItineraryReadRQ>";

        $this->ObjConnectionkiu->Connection();
        $response = $this->ObjConnectionkiu->SendMessage($request);
//        return $response;
        if ($this->ObjConnectionkiu->GetErrorCode() != 0)
            $response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";

        if ($IdTicket != '' && $CodReserva == '' && $Email == '') {
            return simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
        } else {
//            return simplexml_load_string($response);
            return $response;
//            $array = array();
////            $array[] = simplexml_load_string($response);
////            $array[] = htmlspecialchars($request, ENT_QUOTES);
////            $array[] = htmlspecialchars($response, ENT_QUOTES);
////            $array[] = new SimpleXMLElement($response);
////            return $array;
//            $array[] = $response;
//            $array[] = simplexml_load_string($response);
            return simplexml_load_string($response);
//            return $array;
        }
    }

    public function Model_AirCancelRQ($args) {
        $default = array("IdReserva" => "", "IdTicket" => "");
        extract(array_merge($default, $args));
        $request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                  <KIU_CancelRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\">
                        <POS>
                            <Source AgentSine=\"$this->Sine\" TerminalID=\"$this->Device\" ></Source>
                        </POS>";
        if ($IdTicket != '') {
            $request .= "<UniqueID Type=\"30\" ID=\"$IdTicket\" ></UniqueID>";
        }
        $request .= "<UniqueID Type=\"14\" ID=\"$IdReserva\" ></UniqueID>";
        $request .= "<Ticketing TicketTimeLimit=\"1\" />";
        $request .= "</KIU_CancelRQ>";

        $this->Connection();
        $response = $this->SendMessage($request);
        if ($this->ErrorCode != 0)
            $response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";
        return simplexml_load_string($response);
    }

    public function Model_AirFareDisplayRQ($args) {

        $default = array("today" => "", "cod_origen" => "", "cod_destino" => "");
        extract(array_merge($default, $args));

        $request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <KIU_AirFareDisplayRQ Version=\"3.0\" SequenceNmbr=\"1\" PrimaryLangID=\"es-es\" DisplayOrder=\"ByPriceLowToHigh\" EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" DirectFlightsOnly=\"false\" AvailableFlightsOnly=\"true\">
                    <POS>
                            <Source AgentSine=\"LIM002IWW\" TerminalID=\"LIM002IX01\" ISOCountry=\"PE\"/>
                    </POS>
                    <OriginDestinationInformation>
                        <DepartureDateTime>$today</DepartureDateTime>
                        <OriginLocation LocationCode=\"$cod_origen\"/>
                        <DestinationLocation LocationCode=\"$cod_destino\"/>
                    </OriginDestinationInformation>

                    <TravelPreferences>
                            <FareRestrictPref FareDisplayCurrency=\"USD\"/>
                    </TravelPreferences>
            </KIU_AirFareDisplayRQ>";

        $this->ObjConnectionkiu->Connection();
        $response = $this->ObjConnectionkiu->SendMessage($request);

        if ($this->ObjConnectionkiu->GetErrorCode() != 0)
            $response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";
        $array[] = simplexml_load_string($response);
        $array[] = htmlspecialchars($request, ENT_QUOTES);
        $array[] = htmlspecialchars($response, ENT_QUOTES);
        return $array;
    }

}

?>