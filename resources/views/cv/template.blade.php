<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV {{ $profile->name ?? '' }}</title>
    <style>
        @page {
            margin: 50px 55px;
            size: 793px 1123px;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #333333;
            line-height: 1.5;
        }

        /* ===== Header ===== */
        table.header {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 22px;
        }
        table.header td {
            vertical-align: middle;
            padding: 0;
        }
        .header-photo {
            width: 118px;
            text-align: center;
        }
        .header-photo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #1E3A8A;
        }
        .header-info {
            padding-left: 24px;
        }
        .name {
            font-size: 30px;
            font-weight: bold;
            color: #111111;
            letter-spacing: 0.3px;
        }
        .major {
            font-size: 14.5px;
            font-weight: normal;
            color: #1E3A8A;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin: 4px 0 11px;
        }
        .contact-line {
            font-size: 13px;
            color: #555555;
        }
        .contact-line .sep {
            color: #bbbbbb;
            padding: 0 8px;
        }

        hr.divider {
            border: none;
            border-top: 1px solid #d8d8d8;
            margin-bottom: 20px;
        }

        /* ===== Sections ===== */
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .section:last-child {
            margin-bottom: 0;
        }
        .section-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1E3A8A;
            letter-spacing: 1.6px;
            padding-bottom: 5px;
            margin-bottom: 12px;
            border-bottom: 1.5px solid #1E3A8A;
            page-break-after: avoid;
        }
        .summary {
            text-align: left;
            font-size: 12.5px;
            line-height: 1.75;
            color: #444444;
            width: 92%;
        }

        /* ===== Pendidikan ===== */
        table.edu-row {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table.edu-row:last-child {
            margin-bottom: 0;
        }
        table.edu-row td {
            vertical-align: top;
            padding: 0;
        }
        .edu-school {
            font-weight: bold;
            font-size: 13px;
            color: #111111;
        }
        .edu-major {
            font-size: 12px;
            color: #666666;
            margin-top: 1px;
        }
        .edu-period {
            font-size: 11.5px;
            color: #888888;
            text-align: right;
            white-space: nowrap;
            width: 130px;
        }

        /* ===== Portofolio ===== */
        .project-item {
            margin-bottom: 16px;
        }
        .project-item:last-child {
            margin-bottom: 0;
        }
        .project-title {
            font-weight: bold;
            font-size: 13.5px;
            color: #111111;
            margin-bottom: 4px;
        }
        .project-desc {
            font-size: 12.5px;
            color: #555555;
            line-height: 1.65;
        }

        /* ===== Skill list ===== */
        table.skill-columns {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        table.skill-columns td {
            width: 50%;
            vertical-align: top;
            padding: 0 20px 0 0;
        }
        .skill-group-title {
            font-weight: bold;
            font-size: 11.5px;
            color: #111111;
            text-transform: capitalize;
            margin-bottom: 7px;
        }
        ul.skill-list {
            list-style: disc;
            padding-left: 18px;
        }
        ul.skill-list li {
            font-size: 12px;
            color: #444444;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <table class="header">
        <tr>
            @if($photoBase64)
                <td class="header-photo">
                    <img src="{{ $photoBase64 }}" alt="Foto Profil">
                </td>
            @endif
            <td class="header-info">
                <div class="name">{{ strtoupper($profile->name ?? '') }}</div>
                <div class="major">{{ $profile->major ?? '' }}</div>
                <div class="contact-line">
                    {{ $profile->phone ?? '-' }}<span class="sep">&bull;</span>{{ $profile->email ?? '-' }}<span class="sep">&bull;</span>{{ $profile->location ?? '-' }}
                </div>
            </td>
        </tr>
    </table>

    <hr class="divider">

    <div class="section">
        <div class="section-title">Ringkasan Diri</div>
        <p class="summary">{{ $profile->summary ?? '' }}</p>
    </div>

    <div class="section">
        <div class="section-title">Pendidikan</div>
        @foreach($educations as $edu)
            <table class="edu-row">
                <tr>
                    <td>
                        <div class="edu-school">{{ $edu->school }}</div>
                        @if($edu->major)
                            <div class="edu-major">{{ $edu->major }}</div>
                        @endif
                    </td>
                    <td class="edu-period">{{ $edu->period }}</td>
                </tr>
            </table>
        @endforeach
    </div>

    <div class="section">
        <div class="section-title">Portofolio Proyek</div>
        @foreach($projects as $project)
            <div class="project-item">
                <div class="project-title">{{ $project->title }}</div>
                <div class="project-desc">{{ $project->description }}</div>
            </div>
        @endforeach
    </div>

    <div class="section">
        <div class="section-title">Keahlian</div>
        <table class="skill-columns">
            <tr>
                @foreach($technologies as $category => $techs)
                    <td>
                        <div class="skill-group-title">{{ $category }}</div>
                        <ul class="skill-list">
                            @foreach($techs as $tech)
                                <li>{{ $tech->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                @endforeach
            </tr>
        </table>
    </div>
</body>
</html>
