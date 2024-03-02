<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contract: {{ $contract->employee->user->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap">
    <style>

        body {
            font-family: "Lexend", sans-serif;
            font-size: 13px;
            margin-top: 99px;
            display: flex;
        }

        body>div {
            margin: 20px
        }

        ul {
            list-style-type: dot;
        }

        ul>li {
            margin-bottom: 10px
        }

        ol>li {
            margin-bottom: 15px
        }

        table {
            width: 50%
        }

        tr,
        th,
        td {

            border: 1px solid black;
            padding: 3px;
            margin: 3px;
        }
    </style>
</head>

<body>
    <div>
        <div>
            <span>CONT/1/1/2022/05 EFS/1/</span>
        </div>
        <div style="text-align: right">
            <span>{{ Carbon\Carbon::parse($contract->start_date)->format('jS F, Y') }}</span>
        </div>
    </div>
    <div>
        <strong>{{ $contract->employee->gender == 'male' ? 'Mr.' : 'Ms.' }} &ThickSpace;
            {{ $contract->employee->user->name }}</strong>
    </div>
    <div>
        <strong style="text-decoration: underline; text-transform:uppercase">Offer of Appointment</strong>
    </div>
    <div>
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolor voluptates illo sapiente! Dolorem quam facere
        sequi ullam rem hic repellat consequuntur repellendus quae et, vel obcaecati autem cumque accusamus amet!
    </div>
    <div>
        <ol>
            <li><strong>Reporting</strong>
                <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Neque expedita debitis enim ut optio iure
                    molestiae, dicta recusandae, quam velit corporis quis tempore dolor a deleniti temporibus.
                    Inventore, natus itaque.
                </p>
            </li>
            <li><strong>Duties and Responsibilities</strong>
                <p>
                <ul>
                    @foreach ($contract->employee->designation->responsibilities as $responsibility)
                        <li>{{ $responsibility->responsibility }}</li>
                    @endforeach
                </ul>
                </p>
            </li>
            <li>
                <strong>Duration</strong>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi optio tenetur maiores dolores
                    excepturi! Aperiam soluta, nihil magni eum assumenda unde, repellat facere sed quas in, id ea
                    voluptatibus alias!
                    Dicta voluptatem illum ea.
                </p>
            </li>
            <li>
                <strong>Renewal of Contract</strong>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi optio tenetur maiores dolores
                    excepturi! Aperiam soluta, nihil magni eum assumenda unde, repellat facere sed quas in, id ea
                    voluptatibus alias!
                    Dicta voluptatem illum ea.
                </p>
            </li>
            <li>
                <strong>Place of Work</strong>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi optio tenetur maiores dolores
                    excepturi!
                </p>
            </li>
            <li>
                <strong>Remuneration</strong>
                <p>Your {{ $contract->employment_type_id == 1 ? 'Daily' : 'Monthly' }} Remuneration will be as follows:
                </p>
                <p style="margin:auto">
                    @if ($contract->employment_type_id == 1)
                        <table>
                            <thead>
                                <tr>
                                    <th>Charges</th>
                                    <th>Amount(KES)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Daily Rate</td>
                                    <td>KES {{ number_format($contract->salary_kes) }}</td>
                                </tr>
                                <tr>
                                    <td>House Allowance</td>
                                    <td>KES {{ number_format($contract->house_allowance) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><strong>KES {{ number_format($contract->salary_kes) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:70%"> <Strong>Charges</Strong></th>
                                    <th> Amount (KES)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Basic Salary</td>
                                    <td>KES {{ number_format($contract->salary_kes - $contract->house_allowance) }}</td>
                                </tr>
                                <tr>
                                    <td>House Allowance</td>
                                    <td>KES {{ number_format($contract->house_allowance) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><strong>KES {{ number_format($contract->salary_kes) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Id aspernatur excepturi vitae fugiat illo
                    optio non. Aut esse rerum et sit soluta. Ipsum asperiores nesciunt unde ipsam quae itaque iusto!
                </p>
            </li>
            <li>
                <strong>Medical</strong>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Itaque sit harum maiores ipsa fugiat velit
                    quae et saepe sint neque eaque molestias, magni numquam quidem ullam, quia mollitia aut illo.</p>
            </li>
            <li>
                <strong>Pension Scheme</strong>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore ut voluptatum illum totam non nobis,
                    eos similique ipsum nam maxime vitae odit modi veniam quis quidem corrupti praesentium architecto
                    delectus.
                </p>
            </li>
            <li>
                <strong>Leave</strong>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non ut commodi optio beatae fugit amet omnis
                    quasi labore necessitatibus et nobis minima, vero nemo, eius assumenda, modi adipisci numquam odit.
                </p>
            </li>
            <li><strong>Code of Conduct</strong>
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Est quas, deleniti perspiciatis saepe
                    assumenda minima, dicta fugit consectetur inventore reiciendis possimus facere quam rem quae
                    explicabo qui ipsum voluptates voluptate!
                <ol type="a">
                    <li>
                        <div class="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam hic non,
                            numquam quidem voluptatum debitis</div>
                    </li>
                    <li>
                        <div class="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam hic non,
                            numquam quidem voluptatum debitis</div>
                    </li>
                    <li>
                        <div class="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam hic non,
                            numquam quidem voluptatum debitis</div>
                    </li>
                </ol>

                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, repellat debitis. Hic,
                dignissimos? Deserunt libero maxime odit. Pariatur, similique ratione reprehenderit, ipsum iste eos,
                minima quidem ducimus culpa iusto distinctio.
                Sequi, sapiente reiciendis excepturi culpa voluptatem, debitis iste iusto animi eveniet perspiciatis,
                inventore laboriosam natus repellat? Inventore, facere eius voluptatum illo rerum alias, aperiam
                suscipit, incidunt natus excepturi est nobis!
                Sed at commodi, odit rerum illo aliquid dicta! Obcaecati id enim inventore recusandae eius pariatur,
                numquam odio reiciendis ipsa dolore ullam officiis, laboriosam illo itaque, vitae sapiente accusantium
                iusto nam.
                </p>
            </li>
            <li>
                <strong>Confidentiality</strong>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nisi a doloribus voluptas suscipit
                    molestiae perspiciatis velit praesentium, corporis aspernatur, ab cumque corrupti excepturi, quam
                    harum soluta beatae aliquam mollitia ipsam!</p>
                <ol type="a">
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi placeat esse in, dignissimos eius
                        explicabo provident est minus! Quisquam voluptas repudiandae voluptate quam iure dignissimos
                        quas natus exercitationem fugiat. Nam.</li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi placeat esse in, dignissimos eius
                        explicabo provident est minus! Quisquam voluptas repudiandae voluptate quam iure dignissimos
                        quas natus exercitationem fugiat. Nam.</li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi placeat esse in, dignissimos eius
                        explicabo provident est minus! Quisquam voluptas repudiandae voluptate quam iure dignissimos
                        quas natus exercitationem fugiat. Nam.</li>
                </ol>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt, beatae? Quis iste natus sint.
                    Pariatur reprehenderit harum, unde, nam accusantium ducimus corrupti maiores omnis ut possimus
                    repellendus itaque aliquam modi.
                    Illum expedita error autem provident, aperiam ratione impedit rem voluptatibus blanditiis animi
                    assumenda porro totam explicabo? Ipsum, sed nisi! Voluptates dignissimos magni animi soluta et nam
                    vel est! Explicabo, ad.
                </p>
            </li>
            <li><strong>Termination</strong>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam, illo recusandae quaerat
                    reprehenderit nostrum sapiente, neque provident temporibus iure laborum tempora doloremque,
                    consequatur veritatis eum porro accusamus. Quia, expedita ab.
                    Excepturi eius suscipit vel dolorem praesentium veniam incidunt quaerat dignissimos culpa quae
                    officiis doloribus, eveniet, corporis aliquid molestias exercitationem. Voluptatem ad obcaecati
                    illum placeat tempore molestias quas officiis harum impedit.
                    Dolor enim quidem eligendi. Eos possimus veritatis dolor deleniti, incidunt odit repellendus iusto
                    suscipit, doloremque minima assumenda officiis consectetur quaerat cumque nam quibusdam fugiat
                    consequatur blanditiis mollitia excepturi adipisci dolores?
                </p>
            </li>
            <li>
                <strong>Obligation</strong>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt, deleniti.
                </p>
            </li>
            <li><strong>
                    Acceptance</strong>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis laborum aliquam nobis mollitia
                    libero dolorem, commodi obcaecati officiis ullam atque! Voluptatum ut fugiat neque temporibus ipsa
                    ratione quia doloremque itaque.
                </p>
                <p>
                    I wish to congratulate you on this appointment and wish you well in your duties
                </p>
                <p>
                    Yours Sincerely
                </p>
                <br>
                <br>
                <br>
                <p>Mr. Steve Nyanumba</p>
                <p><strong>ICT DIRECTOR</strong></p>
                <br>
                <br>
                <br>
                <div>
                    <p>
                        <strong><u>ACCEPTANCE</u></strong>
                    </p>
                    <p>
                        I ________________________________________________ <small>(Full
                            name
                            and Postal Address)</small> hereby accept the above offer as per the terms and conditions
                        stipulated herein and will report for duty on _____________________________________. My current
                        physical
                        address is
                        _________________________________________________________.
                        <small>(Please fill in the physical address)</small>
                    </p>

                </div>
            </li>
        </ol>


    </div>

</body>

</html>
