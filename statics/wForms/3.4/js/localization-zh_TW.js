
if(typeof wFORMS.behaviors.validation.messages === 'undefined'){
    wFORMS.behaviors.validation.messages = {};
};

(function(){
    var key, tmp;
    for(key in (tmp = {
        oneRequired 	: "此為必填部分。",
        isRequired 		: "此為必填欄位。",
        isAlpha 		: "只可輸入英文字母（a-z, A-Z）。請勿輸入數字。",
        isEmail 		: "您輸入的電子郵件地址有誤。",
        isInteger 		: "請輸入數字（不要有小數點位數）。",
        isFloat 		: "請輸入數字（例如1.9 ）。",
        isAlphanum 		: "請輸入英文字母與數字 [a-z, 0-9 ] 。",
        isDate 			: "此非有效日期。",
        isDateTime		: "此非有效日期或時間。",
        isTime	    	: "此非有效時間。",
        isPhone			: "請輸入有效的電話號碼。",
        isCustom		: "請輸入有效的數值。",
        isHostname		: "This does not appear to be a valid hostname.",
	    wordCount       : "This field is over the word limit.",
	    wordsRemPos     : "words remaining",
	    wordsRemNeg     : "words over the limit",
        notification_0	: "表格未填完無法送出，您送出的表格有 %% 題問題未正確作答。",
        notification	: "表格未填完無法送出，您送出的表格有 %% 題問題未正確作答。",
        isPasswordStrong: "Please choose a more secure password. Passwords must contain 8 or more characters, with at least 1 letter (a to z), 1 number (0 to 9), and 1 symbol (like \'%\', \'$\' or \'!\').",
        isPasswordMedium: "請輸入更有效的密碼。 密碼必須包含4個或以上字符， 至少有一個字母（a-z）， 一個數字（0-9）",
        isPasswordWeak  : "密碼欄不能為空。",
        isPasswordConfirmed : "您兩次輸入的密碼不一致。",
        rangeNumber    : {
            max: "The value must be smaller than the upper bound %1.",
            min: "The value must be greater than the lower bound %1.",
            both:"The entered value must be between %1 - %2"
        },
        rangeDate   : {
            max:  "The date must be on or before %1.",
            min:  "The date must be on or after %1.",
            both: "This date must be between %1 - %2.",
            cont: "This field determines the date range for %1.",
            dep:  "Could not validated date. This field is dependent on %1.",
            link: "another field"
        },
        wait            : "Please wait..."
    })){
        wFORMS.behaviors.validation.messages[key] = tmp[key];
    }
})();

if(typeof wFORMS.footer === 'undefined'){
    wFORMS.footer = {messages : {}};
};

// add translations for new gdpr links
wFORMS.footer.messages = {
    contactInformation : "Contact Information",
    gdprRights : "Your Rights Under GDPR"
}

wFORMS.behaviors.lengthPrompt.messages = "%1 characters left.";

wFORMS.behaviors.repeat.MESSAGES = {
	ADD_CAPTION 	: "新增另一個表格",
	ADD_TITLE 		: "系統將複製此問題或段落。",
	REMOVE_CAPTION 	: "刪除",
	REMOVE_TITLE 	: "系統將刪除此問題或段落",
	REMOVE_WARNING  : "Are you sure you want to remove this section? All data in this section will be lost."
};



(function(){
    var key, tmp;
    for(key in (tmp = {
        CAPTION_NEXT     : '下一頁',
        CAPTION_PREVIOUS : '上一頁',
        CAPTION_UNLOAD   : '表格中填寫的所有資料將全部消失',
        NAV_LABEL :  '頁: ',
        TAB_LABEL :  '頁 '
    })){
        wFORMS.behaviors.paging.MESSAGES[key] = tmp[key];
    }
})();



// Alpha Input Validation:
wFORMS.behaviors.validation.instance.prototype.validateAlpha = function(element, value) {
	var reg =  /^[a-zA-Z\s\u4E00-\u9FFF]+$/;
	return this.isEmpty(value) || reg.test(value);
};
// Alphanumeric Input Validation:
wFORMS.behaviors.validation.instance.prototype.validateAlphanum = function(element, value) {
	var reg =  /^[\u0030-\u0039a-zA-Z\s\u4E00-\u9FFF]+$/;
	return this.isEmpty(value) || reg.test(value);
};

wFORMS.behaviors.autoformat.NUMERIC_REGEX = new RegExp("[0-9]");
wFORMS.behaviors.autoformat.ALPHABETIC_REGEX = new RegExp("[a-zA-Z\s\u4E00-\u9FFF]");

// Calendar
if(!wFORMS.helpers.calendar) {
	wFORMS.helpers.calendar = {};
};
if(!wFORMS.helpers.calendar.locale) {
	wFORMS.helpers.calendar.locale = {};
};
var cfg = wFORMS.helpers.calendar.locale;

cfg.TITLE 				= '選擇日期';
cfg.START_WEEKDAY 		= 0;
cfg.MONTHS_LONG			= [	'一月',
							'二月',
							'三月',
							'四月',
							'五月',
							'六月',
							'七月',
							'八月',
							'九月',
							'十月',
							'十一月',
							'十二月'
							];
cfg.WEEKDAYS_SHORT		= [ '星期日',
							'星期一',
							'星期二',
							'星期三',
							'星期四',
							'星期五',
							'星期六'
							];
cfg.MDY_DAY_POSITION 		= 3;
cfg.MDY_MONTH_POSITION 		= 2;
cfg.MDY_YEAR_POSITION		= 1;
cfg.DATE_FIELD_DELIMITER	= '/';

// Autosuggest
(function(){
    var key, tmp;
    for(key in (tmp = {
        NO_RESULTS     : 'No results found'        
    })){
        if(wFORMS.behaviors.autosuggest) {
            wFORMS.behaviors.autosuggest.MESSAGES[key] = tmp[key];
        }
    }
})();

// Numeric formatting information
var wFormsNumericLocaleFormattingInfo = {"decimal_point":".","thousands_sep":",","int_curr_symbol":"TWD ","currency_symbol":"NT$","mon_decimal_point":".","mon_thousands_sep":",","positive_sign":"","negative_sign":"-","int_frac_digits":2,"frac_digits":2,"p_cs_precedes":1,"p_sep_by_space":0,"n_cs_precedes":1,"n_sep_by_space":0,"p_sign_posn":1,"n_sign_posn":1,"grouping":[3],"mon_grouping":[3]};
