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
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1a1a1a;
        }
        table.layout {
            width: 100%;
            border-collapse: collapse;
        }
        td.sidebar {
            width: 35%;
            background-color: #0d2a4d;
            color: #ffffff;
            padding: 30px 20px;
            vertical-align: top;
        }
        td.main {
            width: 65%;
            padding: 40px 30px;
            vertical-align: top;
        }

        /* Sidebar */
        .photo-wrap {
            text-align: center;
            margin-bottom: 25px;
        }
        .photo-wrap img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #ffffff;
        }
        .sidebar h2 {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            margin-top: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.3);
            padding-bottom: 6px;
        }
        .sidebar p {
            margin-bottom: 8px;
            line-height: 1.5;
        }
        .edu-item {
            margin-bottom: 14px;
        }
        .edu-period {
            font-size: 10px;
            opacity: 0.85;
        }
        .edu-school {
            font-weight: bold;
        }
        .skill-list {
            list-style: none;
        }
        .skill-list li {
            margin-bottom: 6px;
            padding-left: 12px;
            position: relative;
        }
        .skill-list li:before {
            content: "•";
            position: absolute;
            left: 0;
        }
        .skill-category {
            font-size: 11px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 4px;
        }

        /* Main content */
        .name {
            font-size: 26px;
            font-weight: bold;
            color: #0d2a4d;
            line-height: 1.2;
        }
        .major {
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #333;
            margin-top: 6px;
            margin-bottom: 25px;
        }
        .main h2 {
            font-size: 16px;
            color: #0d2a4d;
            margin-bottom: 10px;
            margin-top: 20px;
        }
        .main p.summary {
            line-height: 1.6;
            text-align: justify;
        }
        .project-item {
            margin-bottom: 16px;
        }
        .project-title {
            font-weight: bold;
            color: #0d2a4d;
            font-size: 12px;
            margin-bottom: 4px;
        }
        .project-desc {
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <table class="layout">
        <tr>
            <td class="sidebar">
                @if($photoBase64)
                    <div class="photo-wrap">
                        <img src="{{ $photoBase64 }}" alt="Foto Profil">
                    </div>
                @endif

                <h2>Kontak</h2>
                <p>{{ $profile->phone ?? '-' }}</p>
                <p>{{ $profile->email ?? '-' }}</p>
                <p>{{ $profile->location ?? '-' }}</p>

                <h2>Pendidikan</h2>
                @foreach($educations as $edu)
                    <div class="edu-item">
                        <div class="edu-period">{{ $edu->period }}</div>
                        <div class="edu-school">{{ $edu->school }}</div>
                        @if($edu->major)
                            <div>{{ $edu->major }}</div>
                        @endif
                    </div>
                @endforeach

                <h2>Skill</h2>
                @foreach($technologies as $category => $techs)
                    <div class="skill-category">{{ $category }}</div>
                    <ul class="skill-list">
                        @foreach($techs as $tech)
                            <li>{{ $tech->name }}</li>
                        @endforeach
                    </ul>
                @endforeach
            </td>

            <td class="main">
                <div class="name">{{ strtoupper($profile->name ?? '') }}</div>
                <div class="major">{{ $profile->major ?? '' }}</div>

                <h2>Profil</h2>
                <p class="summary">{{ $profile->summary ?? '' }}</p>

                <h2>Portofolio Proyek</h2>
                @foreach($projects as $project)
                    <div class="project-item">
                        <div class="project-title">{{ $project->title }}</div>
                        <div class="project-desc">{{ $project->description }}</div>
                    </div>
                @endforeach
            </td>
        </tr>
    </table>
</body>
</html>
