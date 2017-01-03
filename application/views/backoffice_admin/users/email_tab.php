<div class="row">
    <!-- 1st col -->
    <div style="width:330px;margin:2px 5px;float:left;">
        <div style="float:left; padding:2px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Server</div>
            <div style="float:left; width:220px;">
                <input type="text" class="form-control addUserField emailtab" id="add_eserver" name="SmtpServer" placeholder="Server">
            </div>
        </div>

        <div style="float:left; padding:2px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">User Name</div>
            <div style="float:left; width:220px;">
                <input type="text" class="form-control addUserField emailtab" id="add_eusername" name="UserName" placeholder="User Name">
            </div>
        </div>

        <div style="float:left; padding:2px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">From Email</div>
            <div style="float:left; width:220px;">
                <input type="email" class="form-control addUserField emailtab" id="add_fromemail" name="FromEmail" placeholder="From Email">
            </div>
        </div>

        <div style="float:left; padding:2px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Reply Email</div>
            <div style="float:left; width:220px;">
                <input type="email" class="form-control addUserField emailtab" id="add_replytoemail" name="ReplyToEmail" placeholder="Reply Email">
            </div>
        </div>

        <div style="float:left; padding:2px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Signature</div>
            <div style="float:left; width:220px;">
                <textarea class="form-control addUserField emailtab" id="add_signature" name="Signature"
                          placeholder="Signature"
                    ></textarea>
            </div>
        </div>


    </div>
    <!-- 2nd col -->
    <div style="width:330px;margin:2px 5px;float:left;">
        <div style="float:left; padding:2px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Secure</div>
            <div style="float:left; width:220px;">
                <jqx-drop-down-list class="form-control addUserField emailtab" id="add_esecure" name="SMTPSecure"
                    jqx-place-holder="Secure" jqx-height="20" jqx-width="195">
                    <option value="">None</option>
                    <option value="ssl">SSL</option>
                    <option value="tls">TLS</option>
                </jqx-drop-down-list>
            </div>
        </div>

        <div style="float:left; padding:2px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Password</div>
            <div style="float:left; width:220px;">
                <input type="password" class="form-control addUserField emailtab" id="add_epassword" name="Password" placeholder="Password">
            </div>
        </div>

        <div style="float:left; padding:2px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">From Name</div>
            <div style="float:left; width:220px;">
                <input type="text" class="form-control addUserField emailtab" id="add_fromname" name="FromName" placeholder="From Name">
            </div>
        </div>

        <div style="float:left; padding:2px;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Reply Name</div>
            <div style="float:left; width:220px;">
                <input type="text" class="form-control addUserField emailtab" id="add_replytoname" name="ReplyToName" placeholder="Reply Name">
            </div>
        </div>

        <div style="float:left;">
            <div style="float:left; padding:8px; text-align:right; width:100px; font-weight:bold;">Port</div>
            <div style="float:left; width:220px;">
                <input type="number" class="form-control addUserField emailtab" id="add_port" name="Port"
                       placeholder="Port" max="9999" min="1" maxlength="4" value="465">
            </div>
        </div>

    </div>
</div>