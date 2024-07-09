@include('emails.header')


<table id="u_content_text_3" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0"
    cellspacing="0" width="100%" border="0">
    <tbody>
        <tr>
            <td class="v-container-padding-padding"
                style="overflow-wrap:break-word;word-break:break-word;padding:10px 55px 40px;font-family:arial,helvetica,sans-serif;"
                align="left">

                <div style="font-size: 14px; line-height: 170%; text-align: left; word-wrap: break-word;">

                    <p style="font-size: 14px; line-height: 170%;">
                        <span style="font-family: Lato, sans-serif; font-size: 16px; line-height: 27.2px;">
                            Hi!
                        </span>
                    </p>
                    <p style="font-size: 14px; line-height: 170%;">
                        <span style="font-family: Lato, sans-serif; font-size: 16px; line-height: 27.2px;">
                            Your verification code is: {{ $verificationCode }}
                        </span>
                    </p>
                    <p style="font-size: 14px; line-height: 170%;"> </p>
                    <p style="font-size: 14px; line-height: 170%;">
                        <span style="font-family: Lato, sans-serif; font-size: 16px; line-height: 27.2px;">
                            If you did not request this, please ignore this email.
                        </span>
                    </p>
                    <p style="font-size: 14px; line-height: 170%;"> </p>
                    <p style="font-size: 14px; line-height: 170%;">
                        <span style="font-family: Lato, sans-serif; font-size: 16px; line-height: 27.2px;">
                            Thank you,
                        </span>
                    </p>

                </div>

            </td>
        </tr>
    </tbody>
</table>







@include('emails.footer')
