<?php
class render_option_ext{
    function RenderListOptionsExt1($istanza) {
        global $Security, $Language;
        $links = "";
        $btngrps = "";
        $sSqlWrk = "`Customer_ID`='" . ew_AdjustSql($istanza->Customer_Number->CurrentValue, $istanza->DBID) . "'";

        // Column "detail_a_sales"
        if ($istanza->DetailPages->Items["a_sales"]->Visible) {
            $link = "";
            $option = &$istanza->ListOptions->Items["detail_a_sales"];
            $url = "a_salespreview.php?t=a_customers&f=" . ew_Encrypt($sSqlWrk);
            $btngrp = "<div data-table=\"a_sales\" data-url=\"" . $url . "\" class=\"btn-group\">";
            if ($Security->AllowList(CurrentProjectID() . 'a_sales')) {
                $label = $Language->TablePhrase("a_sales", "TblCaption");

                // $label .= "&nbsp;" . ew_JsEncode2(str_replace("%c", $this->a_sales_Count, $Language->Phrase("DetailCount")));
                if ( $istanza->a_sales_Count > 0 && @MS_SHOW_DETAILCOUNT_GREATER_THAN_ZERO_ONLY == TRUE ) {
                    if (@MS_USE_BADGE_FOR_DETAILCOUNT) {
                        $label .= "&nbsp; <span class='badge badge-info'>".$istanza->a_sales_Count."</span>";
                    } else {
                        $label .= "&nbsp;" . ew_JsEncode2(str_replace("%c", $istanza->a_sales_Count, $Language->Phrase("DetailCount")));
                    }
                } elseif ( $istanza->a_sales_Count >= 0 && @MS_SHOW_DETAILCOUNT_GREATER_THAN_ZERO_ONLY == FALSE ) {
                    if (@MS_USE_BADGE_FOR_DETAILCOUNT) {
                        $label .= "&nbsp; <span class='badge badge-info'>".$istanza->a_sales_Count."</span>";
                    } else {
                        $label .= "&nbsp;" . ew_JsEncode2(str_replace("%c", $istanza->a_sales_Count, $Language->Phrase("DetailCount")));
                    }
                }
                $link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"a_sales\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = ew_JsEncode3("a_saleslist.php?" . EW_TABLE_SHOW_MASTER . "=a_customers&fk_Customer_Number=" . urlencode(strval($istanza->Customer_Number->CurrentValue)) . "");
                $btngrp .= "<button type=\"button\" class=\"btn btn-default btn-sm\" title=\"" . $Language->TablePhrase("a_sales", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->Phrase("MasterDetailListLink") . "</button>";
            }
            if ($GLOBALS["a_sales_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'a_sales'))
                $btngrp .= "<button type=\"button\" class=\"btn btn-default btn-sm\" title=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" onclick=\"window.location='" . $istanza->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=a_sales") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
            if ($GLOBALS["a_sales_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'a_sales'))
                $btngrp .= "<button type=\"button\" class=\"btn btn-default btn-sm\" title=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" onclick=\"window.location='" . $istanza->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=a_sales") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
            $btngrp .= "</div>";
            if ($link <> "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
            }
        }

        // Show detail items if necessary, modification based on v11.0.2, by Masino Sinaga, October 13, 2014
        $showdtl = FALSE;
        foreach ($istanza->ListOptions->Items as $item) {
            if ($item->Name <> $istanza->ListOptions->GroupOptionName && $item->Visible && $item->ShowInDropDown && substr($item->Name,0,7) <> "detail_") {
                $showdtl = TRUE;
                break;
            }
        }
        if ($showdtl) {
            foreach ($istanza->ListOptions->Items as $item) {
                if (substr($item->Name,0,7) == "detail_") {
                    $item->Visible = TRUE;
                }
            }
        }

        // Column "preview"
        $option = &$istanza->ListOptions->GetItem("preview");
        if (!$option) { // Add preview column
            $option = &$istanza->ListOptions->Add("preview");
            $option->OnLeft = TRUE;
            if ($option->OnLeft) {
                $option->MoveTo($istanza->ListOptions->ItemPos("checkbox") + 1);
            } else {
                $option->MoveTo($istanza->ListOptions->ItemPos("checkbox"));
            }
            $option->Visible = !($istanza->Export <> "" || $istanza->CurrentAction == "gridadd" || $istanza->CurrentAction == "gridedit");
            $option->ShowInDropDown = FALSE;
            $option->ShowInButtonGroup = FALSE;
        }
        if ($option) {
            $option->Body = "<span class=\"ewPreviewRowBtn icon-expand\"></span>";
            $option->Body .= "<div class=\"hide ewPreview\">" . $links . $btngrps . "</div>";
            if ($option->Visible) $option->Visible = $links <> "";
        }

        // Column "details" (Multiple details)
        $option = &$istanza->ListOptions->GetItem("details");
        if ($option) {
            $option->Body .= "<div class=\"hide ewPreview\">" . $links . $btngrps . "</div>";
            if ($option->Visible) $option->Visible = $links <> "";
        }
    }
}
?>