<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV {{ $profile->name ?? '' }}</title>
    <style>
        @page {
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #2b2b2b;
            line-height: 1.5;
            width: 793px;
        }
        table.layout {
            width: 793px;
            border-collapse: collapse;
        }
        td.sidebar {
            width: 270px;
            background-color: #0d2a4d;
            color: #ffffff;
            padding: 45px 25px;
            vertical-align: top;
        }
        td.main {
            width: 493px;
            padding: 55px 40px;
            vertical-align: top;
        }

        /* ===== Sidebar ===== */
        .photo-wrap {
            text-align: center;
            margin-bottom: 35px;
        }
        .photo-wrap img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 4px solid #ffffff;
        }
        .sidebar-section {
            margin-bottom: 32px;
        }
        .sidebar h2 {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1.5px solid rgba(255,255,255,0.35);
        }
        .sidebar p {
            margin-bottom: 10px;
            line-height: 1.6;
            font-size: 12.5px;
        }
        .edu-item {
            margin-bottom: 18px;
        }
        .edu-period {
            font-size: 11px;
            opacity: 0.8;
            margin-bottom: 2px;
        }
        .edu-school {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 2px;
        }
        .edu-major {
            font-size: 12px;
            opacity: 0.9;
        }
        .skill-category {
            font-size: 12.5px;
            font-weight: bold;
            margin-top: 14px;
            margin-bottom: 8px;
            text-transform: capitalize;
            color: #ffffff;
        }
        .skill-category:first-child {
            margin-top: 0;
        }
        .skill-list {
            list-style: none;
        }
        .skill-list li {
            margin-bottom: 7px;
            padding-left: 14px;
            font-size: 12px;
        }

        /* ===== Main content ===== */
        .name {
            font-size: 32px;
            font-weight: bold;
            color: #0d2a4d;
            line-height: 1.15;
            letter-spacing: 0.5px;
        }
        .major {
            font-size: 13px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #555555;
            margin-top: 10px;
            margin-bottom: 40px;
        }
        .main-section {
            margin-bottom: 36px;
        }
        .main h2 {
            font-size: 18px;
            color: #0d2a4d;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 2px solid #0d2a4d;
        }
        .main p.summary {
            line-height: 1.8;
            text-align: justify;
            font-size: 13px;
            color: #333333;
        }
        .project-item {
            margin-bottom: 22px;
        }
        .project-item:last-child {
            margin-bottom: 0;
        }
        .project-title {
            font-weight: bold;
            color: #0d2a4d;
            font-size: 14.5px;
            margin-bottom: 6px;
        }
        .project-desc {
            line-height: 1.7;
            font-size: 13px;
            color: #333333;
        }
    </style>
</head>
<body>
    <table class="layout">
        <tr>
            <td class="sidebar">
                {{--
                @if($photoBase64)
                    <div class="photo-wrap">
                        <img src="{{ $photoBase64 }}" alt="Foto Profil">
                    </div>
                @endif
                --}}

                <div class="sidebar-section">
                    <h2>Kontak</h2>
                    <p>{{ $profile->phone ?? '-' }}</p>
                    <p>{{ $profile->email ?? '-' }}</p>
                    <p>{{ $profile->location ?? '-' }}</p>
                </div>

                <div class="sidebar-section">
                    <h2>Pendidikan</h2>
                    @foreach($educations as $edu)
                        <div class="edu-item">
                            <div class="edu-period">{{ $edu->period }}</div>
                            <div class="edu-school">{{ $edu->school }}</div>
                            @if($edu->major)
                                <div class="edu-major">{{ $edu->major }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="sidebar-section">
                    <h2>Skill</h2>
                    @foreach($technologies as $category => $techs)
                        <div class="skill-category">{{ $category }}</div>
                        <ul class="skill-list">
                            @foreach($techs as $tech)
                                <li>&bull; {{ $tech->name }}</li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </td>

            <td class="main">
                <div class="name">{{ strtoupper($profile->name ?? '') }}</div>
                <div class="major">{{ $profile->major ?? '' }}</div>

                <div class="main-section">
                    <h2>Profil</h2>
                    <p class="summary">{{ $profile->summary ?? '' }}</p>
                </div>

                <div class="main-section">
                    <h2>Portofolio Proyek</h2>
                    @foreach($projects as $project)
                        <div class="project-item">
                            <div class="project-title">{{ $project->title }}</div>
                            <div class="project-desc">{{ $project->description }}</div>
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
